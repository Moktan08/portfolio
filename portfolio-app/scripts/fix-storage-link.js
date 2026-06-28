const fs = require('node:fs/promises');
const path = require('node:path');
const { execSync } = require('node:child_process');

const projectRoot = path.resolve(__dirname, '..');
const publicStorageLink = path.join(projectRoot, 'public', 'storage');
const storageAppPublic = path.join(projectRoot, 'storage', 'app', 'public');
const configPath = path.join(projectRoot, 'config', 'filesystems.php');

async function pathExists(filePath) {
    try {
        await fs.access(filePath);
        return true;
    } catch {
        return false;
    }
}

async function removePublicStorageLink() {
    if (!await pathExists(publicStorageLink)) {
        console.log('public/storage does not exist, nothing to unlink.');
        return;
    }

    try {
        const stats = await fs.lstat(publicStorageLink);
        if (stats.isSymbolicLink() || stats.isDirectory() || stats.isFile()) {
            await fs.rm(publicStorageLink, { recursive: true, force: true });
            console.log('Removed existing public/storage entry.');
            return;
        }
    } catch (error) {
        console.error('Failed to remove public/storage:', error.message);
        process.exit(1);
    }
}

function runStorageLink() {
    try {
        console.log('Running php artisan storage:link...');
        execSync('php artisan storage:link', {
            cwd: projectRoot,
            stdio: 'inherit',
        });
        console.log('storage:link completed successfully.');
    } catch (error) {
        console.error('php artisan storage:link failed.');
        process.exit(1);
    }
}

async function verifyPublicDiskConfig() {
    try {
        const content = await fs.readFile(configPath, 'utf8');
        const rootMatches = /'public'\s*=>\s*\[([\s\S]*?)\],/m.exec(content);

        if (!rootMatches) {
            console.warn('Unable to locate public disk configuration in config/filesystems.php.');
            return;
        }

        const publicBlock = rootMatches[1];
        const rootValid = /'root'\s*=>\s*storage_path\('app\/public'\)/.test(publicBlock);
        const urlValid = /'url'\s*=>\s*rtrim\(env\('APP_URL'[^)]*\)\s*\.\s*'\/storage'/.test(publicBlock);
        const visibilityValid = /'visibility'\s*=>\s*'public'/.test(publicBlock);

        console.log('\nPublic disk configuration check:');
        console.log(`  root     : ${rootValid ? 'ok' : 'missing'}`);
        console.log(`  url      : ${urlValid ? 'ok' : 'missing'}`);
        console.log(`  visibility: ${visibilityValid ? 'ok' : 'missing'}`);

        if (!rootValid || !urlValid || !visibilityValid) {
            console.warn('Your public disk mapping is not fully correct. It should match storage/app/public to /storage.');
        } else {
            console.log('The public disk mapping appears correct for /storage URL prefix.');
        }
    } catch (error) {
        console.error('Error reading config/filesystems.php:', error.message);
    }
}

async function verifyRuntimePaths() {
    const shouldExist = [storageAppPublic, path.join(projectRoot, 'public', 'storage')];

    for (const runtimePath of shouldExist) {
        console.log(`Checking: ${runtimePath}`);
        console.log(`  exists: ${await pathExists(runtimePath)}`);
    }
}

(async function main() {
    await removePublicStorageLink();

    try {
        await fs.mkdir(storageAppPublic, { recursive: true });
        console.log('Ensured storage/app/public exists.');
    } catch (error) {
        console.error('Unable to create storage/app/public:', error.message);
        process.exit(1);
    }

    runStorageLink();
    await verifyPublicDiskConfig();
    await verifyRuntimePaths();
})();
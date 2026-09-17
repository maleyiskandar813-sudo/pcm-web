import { readdirSync, readFileSync, writeFileSync, unlinkSync, existsSync } from 'node:fs';
import { join, dirname } from 'node:path';
import { fileURLToPath } from 'node:url';

const assetsDir = join(dirname(fileURLToPath(import.meta.url)), '..', 'public', 'build', 'assets');

const fontsCss = readdirSync(assetsDir).filter((f) => f.startsWith('fonts-') && f.endsWith('.css'));

for (const css of fontsCss) {
    const path = join(assetsDir, css);
    const original = readFileSync(path, 'utf8');
    const stripped = original
        .replace(/, url\([^)]+\.woff\) format\('woff'\)/g, '')
        .replace(/,url\([^)]+\.woff\) format\('woff'\)/g, '');
    writeFileSync(path, stripped);
    console.log(`stripped woff sources: ${css}`);
}

for (const f of readdirSync(assetsDir)) {
    if (f.endsWith('.woff') && !f.endsWith('.woff2')) {
        const path = join(assetsDir, f);
        if (existsSync(path)) {
            unlinkSync(path);
            console.log(`removed: ${f}`);
        }
    }
}

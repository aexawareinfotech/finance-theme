import sharp from 'sharp';
import { readdirSync, statSync } from 'fs';
import { join, extname } from 'path';

const LOANS_DIR = './assets/images/loans';
const SCREENSHOT = './screenshot.png';

// Target max dimension for loan images
const MAX_DIMENSION = 1200;

async function compressImage(inputPath, isScreenshot = false) {
    const sizeBefore = statSync(inputPath).size;
    const outputPath = inputPath.replace(/\.(jpg|jpeg|png)$/i, '.webp');

    console.log(`Processing: ${inputPath} (${(sizeBefore / 1024 / 1024).toFixed(2)} MB)`);

    try {
        let pipeline = sharp(inputPath);
        const fs = await import('fs/promises');

        if (isScreenshot) {
            // Screenshot should be 1200x900 per WP guidelines
            pipeline = pipeline.resize(1200, 900, { fit: 'inside', withoutEnlargement: true });
            // Keep screenshot as PNG but compressed
            pipeline = pipeline.png({ compressionLevel: 9, palette: true });
            await pipeline.toFile(inputPath + '.tmp');

            await fs.unlink(inputPath);
            await fs.rename(inputPath + '.tmp', inputPath);

            const sizeAfter = statSync(inputPath).size;
            console.log(`  → Compressed PNG: ${(sizeAfter / 1024).toFixed(0)} KB (saved ${((1 - sizeAfter / sizeBefore) * 100).toFixed(1)}%)`);
        } else {
            // Convert to WebP lossless
            pipeline = pipeline.resize(MAX_DIMENSION, MAX_DIMENSION, { fit: 'inside', withoutEnlargement: true });
            pipeline = pipeline.webp({ lossless: true, effort: 6 });
            await pipeline.toFile(outputPath);

            // Remove original JPG
            await fs.unlink(inputPath);

            const sizeAfter = statSync(outputPath).size;
            console.log(`  → WebP lossless: ${(sizeAfter / 1024).toFixed(0)} KB (saved ${((1 - sizeAfter / sizeBefore) * 100).toFixed(1)}%)`);
        }
    } catch (err) {
        console.error(`  × Error: ${err.message}`);
    }
}

async function main() {
    console.log('=== Image Conversion to WebP (Lossless) ===\n');

    // Convert loan images to WebP
    console.log('Converting loan images to WebP lossless...');
    const loanImages = readdirSync(LOANS_DIR).filter(f => /\.(jpg|jpeg|png)$/i.test(f));

    for (const img of loanImages) {
        await compressImage(join(LOANS_DIR, img));
    }

    // Compress screenshot (keep as PNG for WordPress theme requirement)
    console.log('\nCompressing screenshot...');
    await compressImage(SCREENSHOT, true);

    console.log('\n=== Done! ===');
    console.log('\nNOTE: Update theme files to reference .webp instead of .jpg');
}

main().catch(console.error);

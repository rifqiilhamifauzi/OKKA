const fs = require('fs');
const path = require('path');
function walkDir(dir, callback) {
    fs.readdirSync(dir).forEach(f => {
        let dirPath = path.join(dir, f);
        fs.statSync(dirPath).isDirectory() ? walkDir(dirPath, callback) : callback(dirPath);
    });
}
walkDir('./resources/js', function(filePath) {
    if (filePath.endsWith('.vue')) {
        let content = fs.readFileSync(filePath, 'utf8');
        let original = content;

        // Revert text colors to neutral stone/black colors
        content = content.replace(/text-blue-950/g, 'text-stone-900');
        content = content.replace(/text-blue-900/g, 'text-stone-800');
        
        // We shouldn't revert text-blue-800 if it's used for primary links now. 
        // Wait, originally it was text-stone-700 or text-stone-800. 
        // I will revert text-blue-800 back to text-stone-700, EXCEPT in buttons.
        // Actually, just regular expressions:
        content = content.replace(/text-slate-800/g, 'text-stone-800');
        content = content.replace(/text-slate-700/g, 'text-stone-700');
        content = content.replace(/text-slate-600/g, 'text-stone-600');
        content = content.replace(/text-slate-500/g, 'text-stone-500');
        content = content.replace(/text-slate-400/g, 'text-stone-400');
        
        // Let's also restore standard background for main layout panels if they feel too "blue".
        // The user specifically said "tulisan" (text), so I will stick to text for now.

        if (content !== original) {
            fs.writeFileSync(filePath, content);
            console.log('Fixed text colors in: ' + filePath);
        }
    }
});

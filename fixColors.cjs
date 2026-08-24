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

        // 1. Success Flash Messages
        content = content.replace(/bg-amber-50 border border-amber-100 text-amber-600/g, 'bg-emerald-50 border border-emerald-200 text-emerald-700');
        content = content.replace(/text-amber-400(.*)M9 12l2 2 4-4m6 2/g, 'text-emerald-500$1M9 12l2 2 4-4m6 2');
        content = content.replace(/text-amber-500(.*)M9 12l2 2 4-4m6 2/g, 'text-emerald-500$1M9 12l2 2 4-4m6 2');

        // 2. Buttons: 
        content = content.replace(/bg-amber-600 hover:bg-blue-800 text-white/g, 'bg-blue-600 hover:bg-blue-700 text-white shadow-md');
        content = content.replace(/bg-amber-600 text-base/g, 'bg-blue-600 text-base');

        if (!filePath.includes('Home.vue')) {
            content = content.replace(/bg-amber-500 hover:bg-amber-400 text-blue-950/g, 'bg-blue-600 hover:bg-blue-700 text-white shadow-md');
            content = content.replace(/bg-amber-600 hover:bg-amber-500 text-white/g, 'bg-blue-600 hover:bg-blue-700 text-white shadow-md');
            content = content.replace(/bg-amber-600 hover:bg-blue-800/g, 'bg-blue-600 hover:bg-blue-700');
            content = content.replace(/bg-amber-600 hover:bg-amber-700/g, 'bg-blue-600 hover:bg-blue-700');
            content = content.replace(/bg-amber-50 hover:bg-amber-100 text-amber-600/g, 'bg-blue-50 hover:bg-blue-100 text-blue-600');
            content = content.replace(/text-amber-600 focus:ring-amber-500/g, 'text-blue-600 focus:ring-blue-500');
        }

        // 3. Status Badges:
        content = content.replace(/bg-amber-50 text-blue-800(.*?)Aktif/g, 'bg-emerald-100 text-emerald-800$1Aktif');
        content = content.replace(/bg-amber-50 text-blue-800(.*?)Selesai/g, 'bg-slate-100 text-slate-800$1Selesai');
        content = content.replace(/bg-amber-400 mr-1.5/g, 'bg-emerald-500 mr-1.5'); 
        
        content = content.replace(/bg-amber-50 text-blue-800(.*?)Lolos/g, 'bg-emerald-100 text-emerald-800$1Lolos');
        content = content.replace(/bg-amber-50 text-blue-800(.*?)Approved/g, 'bg-emerald-100 text-emerald-800$1Approved');
        content = content.replace(/bg-amber-50 text-blue-800(.*?)Terverifikasi/g, 'bg-blue-100 text-blue-800$1Terverifikasi');
        content = content.replace(/bg-amber-50 text-blue-800(.*?)Menunggu/g, 'bg-amber-100 text-amber-800$1Menunggu');
        
        content = content.replace(/text-amber-500 text-xs mt-1/g, 'text-red-500 text-xs mt-1'); // Validation errors should be red

        // Form elements like inputs
        content = content.replace(/focus:border-amber-400 focus:ring-amber-400/g, 'focus:border-blue-500 focus:ring-blue-500');
        content = content.replace(/focus:border-amber-500 focus:ring-amber-500/g, 'focus:border-blue-500 focus:ring-blue-500');
        
        // Modal buttons
        content = content.replace(/bg-amber-600 text-base font-medium text-white hover:bg-blue-800/g, 'bg-blue-600 text-base font-medium text-white hover:bg-blue-700');

        if (content !== original) {
            fs.writeFileSync(filePath, content);
            console.log('Fixed file: ' + filePath);
        }
    }
});

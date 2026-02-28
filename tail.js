const fs = require('fs');
const lines = fs.readFileSync('storage/logs/laravel.log', 'utf8').split('\n');
console.log(lines.slice(-50).join('\n'));

with open(r'c:\xampp\htdocs\youleggings\resources\views\frontend\index.blade.php', 'r', encoding='utf-8') as f:
    content = f.read()

# Replace all occurrences of \' with '
content = content.replace("\\'", "'")

with open(r'c:\xampp\htdocs\youleggings\resources\views\frontend\index.blade.php', 'w', encoding='utf-8') as f:
    f.write(content)

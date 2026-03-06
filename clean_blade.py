with open(r'c:\xampp\htdocs\youleggings\resources\views\frontend\index.blade.php', 'r', encoding='utf-8') as f:
    content = f.read()

# Remove backslashes before single quotes in Blade tags
content = content.replace("\\'", "'")

with open(r'c:\xampp\htdocs\youleggings\resources\views\frontend\index.blade.php', 'w', encoding='utf-8') as f:
    f.write(content)

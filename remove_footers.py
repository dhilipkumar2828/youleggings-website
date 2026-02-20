import os
import re

root_dir = r'c:\xampp\htdocs\youleggings\resources\views\backend'
footer_file = r'c:\xampp\htdocs\youleggings\resources\views\backend\layouts\footer.blade.php'

# Regex to find the hardcoded footer
# It matches <footer class="footer"> ... </footer> with explicit text about 2018-2020 E-commerce
pattern = re.compile(r'<footer class="footer">\s*© 2018 - 2020<b> E-commerce<b>\s*</footer>', re.IGNORECASE | re.DOTALL)

files_fixed = 0

for root, dirs, files in os.walk(root_dir):
    for file in files:
        if file.endswith('.blade.php'):
            file_path = os.path.join(root, file)
            
            # Skip the actual footer layout file
            if os.path.normpath(file_path) == os.path.normpath(footer_file):
                continue
                
            with open(file_path, 'r', encoding='utf-8') as f:
                content = f.read()
            
            if pattern.search(content):
                new_content = pattern.sub('', content)
                with open(file_path, 'w', encoding='utf-8') as f:
                    f.write(new_content)
                files_fixed += 1
                print(f"Removed footer from: {file}")

print(f"Total files updated: {files_fixed}")

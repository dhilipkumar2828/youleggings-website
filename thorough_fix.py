import re

with open(r'c:\xampp\htdocs\youleggings\resources\views\frontend\index.blade.php', 'r', encoding='utf-8') as f:
    content = f.read()

# Manual regex to find un-extracted ones
# Things like {{ asset('premium_assets/images/') }}Some Folder/Image.jpg
# Or maybe the original <img src="./images/..." was not replaced if it had single quotes for example.

# Replace `./images/` or `images/` within src=" or src='
content = re.sub(r'src=["\']\./images/([^"]+)["\']', r'src="{{ asset(\'premium_assets/images/\1\') }}"', content)
content = re.sub(r'src=["\']images/([^"]+)["\']', r'src="{{ asset(\'premium_assets/images/\1\') }}"', content)

# Check for the ones that were partially replaced by my bad previous script
# src="{{ asset('premium_assets/images/') }}filename.ext"
# I'll use a lazy quantifier followed by a closing quote.
content = re.sub(r'src="{{ asset\(\'premium_assets/images/\'\) }}([^"]+)"', r'src="{{ asset(\'premium_assets/images/\1\') }}"', content)

with open(r'c:\xampp\htdocs\youleggings\resources\views\frontend\index.blade.php', 'w', encoding='utf-8') as f:
    f.write(content)

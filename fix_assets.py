import re

with open(r'c:\xampp\htdocs\youleggings\resources\views\frontend\index.blade.php', 'r', encoding='utf-8') as f:
    content = f.read()

# Fix src attributes
# Find anything like src="{{ asset('premium_assets/images/') }}filename.ext"
# and change it to src="{{ asset('premium_assets/images/filename.ext') }}"
content = re.sub(r'src="{{ asset\(\'premium_assets/images/\'\) }}([A-Za-z0-9_\-\./]+)"', r'src="{{ asset(\'premium_assets/images/\1\') }}"', content)

# Also fix the one for standard images/ path if any
content = re.sub(r'src="{{ asset\(\'premium_assets/images/\'\) }}([A-Za-z0-9_\-\./]+)"', r'src="{{ asset(\'premium_assets/images/\1\') }}"', content)

# Fix video as well
content = re.sub(r'src="{{ asset\(\'premium_assets/LEGGINGS\.mp4\'\) }}"', r'src="{{ asset(\'premium_assets/LEGGINGS.mp4\') }}"', content)

# Check for duplicates or errors in and URLs in CSS/Style
content = re.sub(r"url\('{{ asset\('premium_assets/images/'\) }}([A-Za-z0-9_\-\./]+)'\)", r"url('{{ asset('premium_assets/images/\1') }}')", content)

with open(r'c:\xampp\htdocs\youleggings\resources\views\frontend\index.blade.php', 'w', encoding='utf-8') as f:
    f.write(content)

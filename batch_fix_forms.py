import os
import re

root_dir = r'c:\xampp\htdocs\youleggings\resources\views\backend'

def fix_file(file_path):
    with open(file_path, 'r', encoding='utf-8') as f:
        content = f.read()

    original_content = content

    # Fix @extends('backend.layouts.notification') to @include
    content = content.replace("@extends('backend.layouts.notification')", "@include('backend.layouts.notification')")
    content = content.replace('@extends("backend.layouts.notification")', '@include("backend.layouts.notification")')

    # Fix <b> You Leggings<b> if found anywhere
    content = content.replace('<b> You Leggings<b>', '<b> You Leggings</b>')

    # Fix grid alignment in form-group row
    # Pattern 1: col-sm-6 label followed by col-sm-10 input (often inside col-md-6)
    # We'll try to detect if it's inside a col-md-6 by looking for preceding text
    
    # A safer approach is to replace col-sm-6 with col-sm-4 and col-sm-10 with col-sm-8 
    # when they are together in a form-group row.
    
    # Use regex to find form-group row blocks
    pattern = re.compile(r'(<div class="form-group row">[\s\S]*?<label.*?class=".*?)col-sm-6(.*?".*?>[\s\S]*?<div.*?class=".*?)col-sm-10(.*?".*?>)', re.IGNORECASE)
    content = pattern.sub(r'\1col-sm-4\2col-sm-8\3', content)

    # If it's still missing, maybe it was col-sm-2/col-sm-10 but the user wants it perfect
    # The CSS I added handles col-sm-2/col-sm-10 well now.

    if content != original_content:
        with open(file_path, 'w', encoding='utf-8') as f:
            f.write(content)
        return True
    return False

files_fixed = 0
for root, dirs, files in os.walk(root_dir):
    for file in files:
        if file.endswith('.blade.php'):
            if fix_file(os.path.join(root, file)):
                files_fixed += 1

print(f"Fixed {files_fixed} files.")

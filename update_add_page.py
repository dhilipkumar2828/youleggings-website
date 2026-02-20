import os

file_path = r'c:\xampp\htdocs\youleggings\resources\views\backend\product\add.blade.php'

with open(file_path, 'r', encoding='utf-8') as f:
    content = f.read()

# Fix the script block for selectvalidation1
new_script = """    function selectvalidation1() {
        let flag = true;
        if ($("#cat_id").val() == '') {
            flag = false;
            $(".cat_error").html("This field is required.");
        } else {
            $(".cat_error").html("");
        }

        if ($('input[name="is_variant"]:checked').val() === 'yes' && $('.variant .card').length == 0) {
            flag = false;
            $("#selectsize").html("Please add at least one variant.");
        } else {
            $("#selectsize").html("");
        }

        if (flag) {
            $('.old_product2').addClass('next');
            $('.old_product2').trigger('click');
            $('.old_product2').removeClass('next');
        } else {
            alert('Please check the required fields or add variants before proceeding to Finish.');
        }
    }"""

import re
pattern = r'function selectvalidation1\(\) \{[\s\S]*?\}'
content = re.sub(pattern, new_script, content)

with open(file_path, 'w', encoding='utf-8') as f:
    f.write(content)

print("File updated successfully.")

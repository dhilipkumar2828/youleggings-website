import os
import re

file_path = r'c:\xampp\htdocs\youleggings\resources\views\backend\product\add.blade.php'

with open(file_path, 'r', encoding='utf-8') as f:
    content = f.read()

# Fix the broken selectvalidation1 and other validation scripts
# We'll replace the entire document.ready block for validation to be sure

new_validation_block = """$(document).ready(function() {
    // Standard Parsley Initialization for the whole form
    var $form = $('#msform');
    if($form.length > 0) {
        $form.parsley();
    }

    function selectvalidation() {
        let flag = true;
        // Validate only visible inputs in the first step
        $('.form-control.required:visible').each(function() {
            if ($(this).val() === '') {
                flag = false;
                $(this).next('.error').text('This field is required.').show();
                $(this).addClass('is-invalid');
            } else {
                $(this).next('.error').text('').hide();
                $(this).removeClass('is-invalid');
            }
        });

        if (flag) {
            $('.next1').hide();
            $('.product1').show();
            $('.product1').click();
        } else {
            alert('Please fill in all required fields.');
        }
    }
    
    function selectvalidation1() {
        let flag = true;
        
        // Category check
        if ($("#cat_id").val() == '') {
            flag = false;
            $(".cat_error").html("This field is required.");
        } else {
            $(".cat_error").html("");
        }

        // Variant check
        if ($('input[name="is_variant"]:checked').val() === 'yes' && $('.variant .card').length == 0) {
            flag = false;
            $("#selectsize").html("Please add at least one variant.");
        } else {
            $("#selectsize").html("");
        }

        // Validate any required2 fields in the second step
        $('.required2:visible').each(function() {
            if ($(this).val().trim() === "") {
                flag = false;
                $(this).next('.err_emptyval').show();
            } else {
                $(this).next('.err_emptyval').hide();
            }
        });

        if (flag) {
            $('.old_product2').addClass('next'); 
            $('.old_product2').trigger('click');
            $('.old_product2').removeClass('next');
        } else {
            alert('Please check the required fields or add variants before proceeding to Finish.');
        }
    }

    // Attach validation functions
    $('.next1').off('click').on('click', selectvalidation);
    $('.next2').off('click').on('click', selectvalidation1);
});"""

# Look for the current document.ready block and replace it
# Using a more robust regex to catch the mess
pattern = r'\$\(document\)\.ready\(function\(\) \{[\s\S]*?\}\);'
# We want to replace the one that contains selectvalidation
# I'll look for a specific one or just do a broader replace

content = re.sub(r'\$\(document\)\.ready\(function\(\) \{\s+function selectvalidation\(\)[\s\S]*?\}\s+\}\s+\);', new_validation_block, content)

# Also fix any stray validation code outside the block if needed
# But usually it's within that block.

with open(file_path, 'w', encoding='utf-8') as f:
    f.write(content)

print("File updated successfully.")

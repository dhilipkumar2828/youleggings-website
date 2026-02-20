import os
import re

file_path = r'c:\xampp\htdocs\youleggings\resources\views\backend\product\edit.blade.php'

with open(file_path, 'r', encoding='utf-8') as f:
    content = f.read()

# Update the Finish fieldset
new_finish = """                                            <fieldset id="finish_fieldset">
                                                <div class="form-card">
                                                    <div class="row">
                                                        <div class="col-7">
                                                            <h3 class="fs-title text-indigo font-weight-bold mb-0">
                                                                <i class="mdi mdi-check-all mr-2"></i>Review & Finish
                                                            </h3>
                                                        </div>
                                                        <div class="col-5">
                                                            <span class="badge badge-indigo p-2 px-3 rounded-pill shadow-sm">STEP 3 OF 3</span>
                                                        </div>
                                                    </div>
                                                    <div class="text-center success-container" style="padding: 40px 0;">
                                                        <div class="success-animation">
                                                            <svg class="checkmark" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 52 52" style="margin: 0 auto; width: 80px; height: 80px;">
                                                                <circle class="checkmark__circle" cx="26" cy="26" r="25" fill="none" style="stroke: #4BB543; stroke-width: 2;" />
                                                                <path class="checkmark__check" fill="none" d="M14.1 27.2l7.1 7.2 16.7-16.8" style="stroke: #4BB543; stroke-width: 3; stroke-linecap: round;" />
                                                            </svg>
                                                        </div>
                                                        <h2 class="text-indigo mt-4"><strong>All Set!</strong></h2>
                                                        <p class="text-muted mt-3">Product basic details and variants have been updated. Click the button below to save all changes.</p>
                                                        <div class="row justify-content-center mt-4">
                                                            <div class="col-md-6">
                                                                <button type="submit" class="btn btn-indigo btn-lg btn-block ripple" style="width: 100%; border-radius: 12px; font-weight: 700; padding: 15px;">Update Product</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <input type="button" name="previous" class="previous action-button-previous mt-4" value="Previous" />
                                            </fieldset>"""

# Find the Loading fieldset and replace it
pattern = r'<fieldset>\s+<div class="form-card">\s+<div class="row">\s+<div class="col-7">\s+<h2 class="fs-title">Finish:</h2>[\s\S]*?</fieldset>'
content = re.sub(pattern, new_finish, content)

with open(file_path, 'w', encoding='utf-8') as f:
    f.write(content)

print("File updated successfully.")

$(document).ready(function() {
    let moduleCount = 0;
    let contentCounts = {};

    // Add Module
    $('#addModuleBtn').click(function() {
        addModule();
    });

    function addModule() {
        moduleCount++;
        contentCounts[moduleCount] = 0;
        
        const moduleHtml = `
            <div class="module-card" data-module-id="${moduleCount}">
                <div class="module-header">
                    <h5 class="mb-0">
                        <i class="fas fa-folder"></i> Module ${moduleCount}
                    </h5>
                    <button type="button" class="btn-remove remove-module" title="Remove Module">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
                
                <div class="p-3">
                    <div class="row mb-3">
                        <div class="col-md-8">
                            <label class="form-label">Module Title <span class="text-danger">*</span></label>
                            <input type="text" 
                                   class="form-control module-title" 
                                   name="modules[${moduleCount}][title]" 
                                   required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Order</label>
                            <input type="number" 
                                   class="form-control" 
                                   name="modules[${moduleCount}][order]" 
                                   value="${moduleCount}" 
                                   min="1">
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Module Description</label>
                        <textarea class="form-control" 
                                  name="modules[${moduleCount}][description]" 
                                  rows="2"></textarea>
                    </div>
                    
                    <!-- Content Section -->
                    <div class="nested-structure">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <h6><i class="fas fa-file-alt"></i> Module Content</h6>
                            <button type="button" class="btn btn-sm btn-info add-content" data-module-id="${moduleCount}">
                                <i class="fas fa-plus"></i> Add Content
                            </button>
                        </div>
                        
                        <div class="content-container" data-module-id="${moduleCount}">
                            <!-- Content items will be added here -->
                        </div>
                    </div>
                </div>
            </div>
        `;
        
        $('#modulesContainer').append(moduleHtml);
        updateModuleNumbers();
    }

    // Remove Module
    $(document).on('click', '.remove-module', function() {
        if (confirm('Are you sure you want to remove this module and all its content?')) {
            $(this).closest('.module-card').remove();
            updateModuleNumbers();
        }
    });

    // Add Content
    $(document).on('click', '.add-content', function() {
        const moduleId = $(this).data('module-id');
        addContent(moduleId);
    });

    function addContent(moduleId) {
        contentCounts[moduleId]++;
        const contentId = contentCounts[moduleId];
        
        const contentHtml = `
            <div class="content-item" data-content-id="${contentId}">
                <div class="content-header">
                    <span><i class="fas fa-file"></i> Content ${contentId}</span>
                    <button type="button" class="btn-remove remove-content" title="Remove Content">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Content Title <span class="text-danger">*</span></label>
                        <input type="text" 
                               class="form-control content-title" 
                               name="modules[${moduleId}][contents][${contentId}][title]" 
                               required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Content Type <span class="text-danger">*</span></label>
                        <select class="form-select content-type" 
                                name="modules[${moduleId}][contents][${contentId}][type]" 
                                required>
                            <option value="">Select Type</option>
                            <option value="text">Text</option>
                            <option value="video">Video</option>
                            <option value="image">Image</option>
                            <option value="link">Link</option>
                            <option value="file">File</option>
                        </select>
                    </div>
                </div>
                
                <div class="mb-3">
                    <label class="form-label">Content Description</label>
                    <textarea class="form-control" 
                              name="modules[${moduleId}][contents][${contentId}][description]" 
                              rows="3"></textarea>
                </div>
                
               
                
                <div class="row">
                    <div class="col-md-6">
                        <label class="form-label">Duration (minutes)</label>
                        <input type="number" 
                               class="form-control" 
                               name="modules[${moduleId}][contents][${contentId}][duration]" 
                               min="1">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Order</label>
                        <input type="number" 
                               class="form-control" 
                               name="modules[${moduleId}][contents][${contentId}][order]" 
                               value="${contentId}" 
                               min="1">
                    </div>
                </div>
            </div>
        `;
        
        $(`.content-container[data-module-id="${moduleId}"]`).append(contentHtml);
    }

    // Remove Content
    $(document).on('click', '.remove-content', function() {
        if (confirm('Are you sure you want to remove this content?')) {
            $(this).closest('.content-item').remove();
        }
    });

    // Content Type Change Handler
    $(document).on('change', '.content-type', function() {
        const contentType = $(this).val();
        const contentItem = $(this).closest('.content-item');
        const specificFields = contentItem.find('.content-specific-fields');
        const moduleId = $(this).closest('.module-card').data('module-id');
        const contentId = contentItem.data('content-id');
        
        let fieldsHtml = '';
        
        switch(contentType) {
            case 'text':
                fieldsHtml = `
                    <div class="mb-3">
                        <label class="form-label">Text Content</label>
                        <textarea class="form-control" 
                                  name="modules[${moduleId}][contents][${contentId}][content]" 
                                  rows="5" 
                                  placeholder="Enter your text content here..."></textarea>
                    </div>
                `;
                break;
                
            case 'video':
                fieldsHtml = `
                    <div class="mb-3">
                        <label class="form-label">Video URL</label>
                        <input type="url" 
                               class="form-control" 
                               name="modules[${moduleId}][contents][${contentId}][url]" 
                               placeholder="https://youtube.com/watch?v=...">
                    </div>
                `;
                break;
                
            case 'image':
                fieldsHtml = `
                    <div class="mb-3">
                        <label class="form-label">Image URL</label>
                        <input type="url" 
                               class="form-control" 
                               name="modules[${moduleId}][contents][${contentId}][url]" 
                               placeholder="https://example.com/image.jpg">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Alt Text</label>
                        <input type="text" 
                               class="form-control" 
                               name="modules[${moduleId}][contents][${contentId}][alt_text]" 
                               placeholder="Description of the image">
                    </div>
                `;
                break;
                
            case 'link':
                fieldsHtml = `
                    <div class="mb-3">
                        <label class="form-label">Link URL</label>
                        <input type="url" 
                               class="form-control" 
                               name="modules[${moduleId}][contents][${contentId}][url]" 
                               placeholder="https://example.com">
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" 
                               type="checkbox" 
                               name="modules[${moduleId}][contents][${contentId}][external]" 
                               value="1">
                        <label class="form-check-label">Open in new tab</label>
                    </div>
                `;
                break;
                
            case 'file':
                fieldsHtml = `
                    <div class="mb-3">
                        <label class="form-label">File URL or Path</label>
                        <input type="text" 
                               class="form-control" 
                               name="modules[${moduleId}][contents][${contentId}][file_path]" 
                               placeholder="path/to/file.pdf">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">File Size (MB)</label>
                        <input type="number" 
                               class="form-control" 
                               name="modules[${moduleId}][contents][${contentId}][file_size]" 
                               step="0.1" 
                               min="0.1">
                    </div>
                `;
                break;
        }
        
        specificFields.html(fieldsHtml);
    });

    function updateModuleNumbers() {
        $('#modulesContainer .module-card').each(function(index) {
            const newNumber = index + 1;
            $(this).find('.module-header h5').html(`<i class="fas fa-folder"></i> Module ${newNumber}`);
        });
    }

    // Form Validation
    $('#courseForm').submit(function(e) {
        let isValid = true;
        let errorMessage = '';

        // Check if at least one module exists
        if ($('.module-card').length === 0) {
            isValid = false;
            errorMessage += 'Please add at least one module to the course.\n';
        }

        // Check each module has a title
        $('.module-title').each(function() {
            if ($(this).val().trim() === '') {
                isValid = false;
                $(this).addClass('is-invalid');
            } else {
                $(this).removeClass('is-invalid');
            }
        });

        // Check each content has required fields
        $('.content-title').each(function() {
            if ($(this).val().trim() === '') {
                isValid = false;
                $(this).addClass('is-invalid');
            } else {
                $(this).removeClass('is-invalid');
            }
        });

        $('.content-type').each(function() {
            if ($(this).val() === '') {
                isValid = false;
                $(this).addClass('is-invalid');
            } else {
                $(this).removeClass('is-invalid');
            }
        });

        if (!isValid) {
            e.preventDefault();
            if (errorMessage) {
                alert(errorMessage);
            }
            $('html, body').animate({
                scrollTop: $('.is-invalid').first().offset().top - 100
            }, 500);
        }
    });

    // Add first module by default
    addModule();
});
<?php 
require_once 'includes/auth_check.php';
require_once '../functions.php';
$blogs = getAll('blogs'); // functions.php se data laya
include('includes/header.php'); 
include('includes/sidebar.php'); 
?>

<!-- CKEditor for Blog Content -->
<script src="https://cdn.ckeditor.com/ckeditor5/36.0.1/classic/ckeditor.js"></script>

<div class="content-area">
    <!-- Breadcrumbs -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold m-0">Blog List</h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb m-0 small">
                <li class="breadcrumb-item"><a href="dashboard.php" class="text-decoration-none text-muted">Home</a></li>
                <li class="breadcrumb-item active fw-bold text-dark" aria-current="page">Blog List</li>
            </ol>
        </nav>
    </div>

    <!-- Main Card -->
    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-header bg-white border-bottom py-3">
            <h6 class="fw-bold m-0 text-muted">Blog List</h6>
        </div>
        <div class="card-body p-4">
            <!-- Add Blog Button -->
            <button class="btn btn-primary px-4 py-2 rounded-3 fw-bold mb-4 shadow-blue" data-bs-toggle="modal" data-bs-target="#blogModal">
                + Add Blog
            </button>

            <!-- Table -->
            <div class="table-responsive">
                <table class="table align-middle">
                    <thead class="table-light">
                        <tr>
                            <th class="border-0">Media</th>
                            <th class="border-0">Title</th>
                            <th class="border-0">Type</th>
                            <th class="border-0 text-end">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if($blogs): foreach($blogs as $b): ?>
                        <tr>
                            <td>
                                <?php if($b['type'] == 'video'): ?>
                                    <div class="bg-light rounded text-center py-2" style="width: 60px;">
                                        <i class="fas fa-video text-primary"></i>
                                    </div>
                                <?php else: ?>
                                    <img src="../<?php echo $b['image']; ?>" width="60" class="rounded shadow-sm">
                                <?php endif; ?>
                            </td>
                            <td class="fw-bold text-dark"><?php echo $b['title']; ?></td>
                            <td><span class="badge bg-light text-dark border px-2"><?php echo strtoupper($b['type']); ?></span></td>
                            <td class="text-end">
                                <a href="../api/admin/manage-blogs.php?action=delete&id=<?php echo $b['id']; ?>" 
                                   class="btn btn-outline-danger btn-sm rounded-3 px-3" 
                                   onclick="return confirm('Delete this blog post?')">
                                    <i class="fas fa-trash-alt"></i>
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; else: ?>
                        <tr>
                            <td colspan="4" class="text-center py-5 text-muted">No blog posts found</td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- --- ADD BLOG MODAL --- -->
<div class="modal fade" id="blogModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 rounded-4 shadow-lg">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold">Add Blog</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="../api/admin/manage-blogs.php?action=add" method="POST" enctype="multipart/form-data">
                <div class="modal-body p-4">
                    
                    <!-- Media Type Dropdown -->
                    <div class="mb-3">
                        <select name="type" id="mediaType" class="form-select custom-input" onchange="toggleMediaInput(this.value)" required>
                            <option value="image">Image</option>
                            <option value="video">Video</option>
                        </select>
                    </div>

                    <!-- Dynamic Upload Box -->
                    <div class="mb-3">
                        <label for="blogMedia" class="upload-box-dashed w-100">
                            <!-- Input name will stay 'image' or 'video' handled by JS or just keep one name and handle in API -->
                            <input type="file" name="media_file" id="blogMedia" hidden onchange="previewMedia(this)" required>
                            <div class="text-center py-3" id="upPlaceholder">
                                <i id="uploadIcon" class="fas fa-cloud-upload-alt text-dark fa-2x mb-2 opacity-75"></i>
                                <p class="small fw-bold text-dark m-0" id="uploadText">Upload image</p>
                            </div>
                            <!-- Image Preview -->
                            <img id="blogPreview" class="d-none w-100 h-100 object-fit-cover rounded-3">
                            <!-- Video Preview Name -->
                            <div id="videoNameDisplay" class="d-none fw-bold text-primary small"></div>
                        </label>
                    </div>

                    <!-- Title -->
                    <div class="mb-3">
                        <input type="text" name="title" class="form-control custom-input" placeholder="Title" required>
                    </div>

                    <!-- Description -->
                    <div class="mb-4">
                        <textarea name="description" id="blogEditor" placeholder="Description"></textarea>
                    </div>

                    <!-- Save Button -->
                    <button type="submit" class="btn btn-primary w-100 py-3 rounded-3 fw-bold shadow-blue">
                        Save
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
.upload-box-dashed { border: 1px dashed #ced4da; border-radius: 12px; background: #ffffff; cursor: pointer; min-height: 140px; display: flex; align-items: center; justify-content: center; position: relative; overflow: hidden;}
.custom-input { border: 1px solid #e0e6ed; border-radius: 10px; padding: 12px 15px; }
.ck-editor__editable { min-height: 180px; }
.shadow-blue { box-shadow: 0 10px 20px rgba(48, 92, 222, 0.2); }
</style>

<script>
    // Logic to toggle Upload Text based on Dropdown
    function toggleMediaInput(type) {
        const text = document.getElementById('uploadText');
        const icon = document.getElementById('uploadIcon');
        const preview = document.getElementById('blogPreview');
        const vidDisplay = document.getElementById('videoNameDisplay');
        const placeholder = document.getElementById('upPlaceholder');

        // Reset
        preview.classList.add('d-none');
        vidDisplay.classList.add('d-none');
        placeholder.classList.remove('d-none');

        if(type === 'video') {
            text.innerText = "Upload video";
            icon.className = "fas fa-file-video text-dark fa-2x mb-2 opacity-75";
            document.getElementById('blogMedia').accept = "video/*";
        } else {
            text.innerText = "Upload image";
            icon.className = "fas fa-cloud-upload-alt text-dark fa-2x mb-2 opacity-75";
            document.getElementById('blogMedia').accept = "image/*";
        }
    }

    // Media Preview Logic
    function previewMedia(input) {
        const type = document.getElementById('mediaType').value;
        const preview = document.getElementById('blogPreview');
        const vidDisplay = document.getElementById('videoNameDisplay');
        const placeholder = document.getElementById('upPlaceholder');

        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                if(type === 'image') {
                    preview.src = e.target.result;
                    preview.classList.remove('d-none');
                    placeholder.classList.add('d-none');
                } else {
                    vidDisplay.innerText = "Selected Video: " + input.files[0].name;
                    vidDisplay.classList.remove('d-none');
                    placeholder.classList.add('d-none');
                }
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    // CKEditor
    ClassicEditor.create(document.querySelector('#blogEditor')).catch(error => { console.error(error); });
</script>

<?php include('includes/footer.php'); ?>
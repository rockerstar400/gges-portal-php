<?php 
require_once '../functions.php';
include 'includes/header.php';
include 'includes/sidebar.php';

$slug = 'eng-common-lang'; 
$data = getTestPrepData($slug); 
?>

<div class="main-content p-4">
    <div class="container-fluid bg-white p-4 p-md-5 shadow-sm rounded-4 border-top border-4 border-primary">
        <h2 class="text-2xl font-bold mb-4">Common English Language Details</h2>

        <form action="api/admin/save-eng-common.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="slug" value="<?= $slug ?>">

            <!-- Main Inputs -->
            <div class="row g-4">
                <div class="col-md-12 mb-3">
                    <label class="form-label fw-bold">Heading</label>
                    <input type="text" name="heading" value="<?= $data['eng_lang_heading'] ?? '' ?>" class="form-control p-3 rounded-3" placeholder="Enter heading" required>
                </div>

                <div class="col-md-12 mb-3">
                    <label class="form-label fw-bold">Description</label>
                    <textarea name="description" class="form-control p-3 rounded-3" rows="4" placeholder="Enter description" required><?= $data['eng_lang_desc'] ?? '' ?></textarea>
                </div>

                <!-- Properties 1 to 5 (Wide UI) -->
                <?php for($i=1; $i<=5; $i++): ?>
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Property <?= $i ?></label>
                    <input type="text" name="property<?= $i ?>" value="<?= $data['eng_lang_prop'.$i] ?? '' ?>" class="form-control p-3 rounded-3 shadow-sm border-info border-opacity-25" placeholder="Enter feature/property <?= $i ?>" required>
                </div>
                <?php endfor; ?>

                <!-- Image Section -->
                <div class="col-md-12 mb-4">
                    <label class="form-label fw-bold">Section Image</label>
                    <div class="border-2 border-dashed border-primary rounded-4 p-5 text-center bg-light">
                        <label class="cursor-pointer">
                            <i class="fas fa-cloud-upload-alt fa-3x text-primary mb-3"></i><br>
                            <span class="fw-bold">Click to Upload Student Image</span>
                            <input type="file" name="image" class="d-none" onchange="previewImg(this)">
                        </label>
                        <div class="mt-4">
                            <?php 
                            $currentImg = !empty($data['eng_lang_image']) ? "../" . $data['eng_lang_image'] : 'https://via.placeholder.com/200x200?text=No+Image'; 
                            ?>
                            <img id="img-prev" src="<?= $currentImg ?>" class="rounded-4 shadow border" style="width: 200px; height: 200px; object-fit: cover;">
                        </div>
                    </div>
                </div>
            </div>

            <div class="text-center mt-5 border-top pt-4">
                <button type="submit" class="btn btn-primary btn-lg px-5 shadow rounded-pill fw-bold">💾 Save Language Details</button>
            </div>
        </form>
    </div>
</div>

<script>
function previewImg(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('img-prev').src = e.target.result;
        }
        reader.readAsDataURL(input.files[0]);
    }
}
</script>

<style>
.border-dashed { border-style: dashed !important; border-width: 2px !important; }
.form-control:focus { border-color: #305CDE; box-shadow: 0 0 0 0.25rem rgba(48, 92, 222, 0.1); }
</style>

<?php include 'includes/footer.php'; ?>
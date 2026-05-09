<?php 
require_once '../functions.php';
include 'includes/header.php';
include 'includes/sidebar.php';

$slug = 'eng-registration'; 
$prepData = getTestPrepData($slug); 

// Registration Data
$regTitle = $prepData['eng_reg_title'] ?? '';
$regDesc  = $prepData['eng_reg_desc'] ?? '';

// Measure Details List
$measureList = $conn->query("SELECT * FROM eng_measure_details ORDER BY id DESC")->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="main-content p-4">
    <div class="container-fluid">
        
        <!-- SECTION 1: REGISTRATION INFO (Main Form) -->
        <div class="bg-white p-6 rounded-xl shadow-sm border-top border-4 border-primary mb-5">
            <h2 class="text-xl font-bold mb-4">Registration Info</h2>
            
            <form action="api/admin/save-eng-reg.php" method="POST">
                <input type="hidden" name="slug" value="<?= $slug ?>">
                
                <div class="mb-4">
                    <label class="fw-bold mb-2">Registration Title</label>
                    <input type="text" name="title" value="<?= htmlspecialchars($regTitle) ?>" class="form-control p-3 rounded-xl" placeholder="Enter registration title..." required>
                </div>

                <div class="mb-4">
                    <label class="fw-bold mb-2">Registration Description</label>
                    <textarea name="description" class="form-control p-3 rounded-xl" rows="4" placeholder="Enter description..." required><?= $regDesc ?></textarea>
                </div>

                <button type="submit" class="btn btn-primary w-100 py-2 fw-bold rounded-pill shadow-sm">Save Registration Info</button>
            </form>
        </div>

        <!-- SECTION 2: MEASURE DETAILS (CRUD List) -->
        <div class="bg-white p-6 rounded-xl shadow-sm border-top border-4 border-success">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="text-xl font-bold">Measure Details</h2>
                <button class="btn btn-success rounded-pill px-4" onclick="openMeasureModal()">+ Add Measure Detail</button>
            </div>

            <div class="table-responsive rounded-3 border overflow-hidden">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr class="small fw-bold text-muted">
                            <th style="width: 30%">Title</th>
                            <th style="width: 55%">Description</th>
                            <th style="width: 15%" class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(!empty($measureList)): foreach($measureList as $item): ?>
                        <tr>
                            <td class="fw-bold text-dark"><?= $item['title'] ?></td>
                            <td class="text-muted small"><?= $item['description'] ?></td>
                            <td class="text-center">
                                <button class="btn btn-sm text-primary me-2" onclick='editMeasure(<?= json_encode($item) ?>)'><i class="fas fa-edit"></i></button>
                                <button class="btn btn-sm text-danger" onclick="deleteMeasure(<?= $item['id'] ?>)"><i class="fas fa-trash"></i></button>
                            </td>
                        </tr>
                        <?php endforeach; else: ?>
                        <tr><td colspan="3" class="text-center py-4 text-muted">No measure details found.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>

<!-- ADD/EDIT MEASURE MODAL -->
<div class="modal fade" id="measureModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <form class="modal-content border-0 shadow-lg rounded-4" action="api/admin/handler-eng-measure.php" method="POST">
            <div class="modal-header border-0">
                <h5 class="modal-title fw-bold" id="modalLabel">Add Measure Detail</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <input type="hidden" name="id" id="measure_id">
                
                <div class="mb-3">
                    <label class="small fw-bold">Title</label>
                    <input type="text" name="title" id="measure_title" class="form-control rounded-3 p-2" placeholder="e.g. Verbal Reasoning" required>
                </div>

                <div class="mb-3">
                    <label class="small fw-bold">Description</label>
                    <textarea name="description" id="measure_desc" class="form-control rounded-3 p-2" rows="4" placeholder="Enter details..." required></textarea>
                </div>
            </div>
            <div class="modal-footer border-0">
                <button type="submit" class="btn btn-primary w-100 py-3 rounded-pill fw-bold shadow">Save Changes</button>
            </div>
        </form>
    </div>
</div>

<script>
function openMeasureModal() {
    document.getElementById('modalLabel').innerText = "Add Measure Detail";
    document.getElementById('measure_id').value = "";
    document.getElementById('measure_title').value = "";
    document.getElementById('measure_desc').value = "";
    new bootstrap.Modal(document.getElementById('measureModal')).show();
}

function editMeasure(data) {
    document.getElementById('modalLabel').innerText = "Edit Measure Detail";
    document.getElementById('measure_id').value = data.id;
    document.getElementById('measure_title').value = data.title;
    document.getElementById('measure_desc').value = data.description;
    new bootstrap.Modal(document.getElementById('measureModal')).show();
}

function deleteMeasure(id) {
    if(confirm('Delete this item?')) {
        window.location.href = 'api/admin/handler-eng-measure.php?delete=' + id;
    }
}
</script>

<?php include 'includes/footer.php'; ?>
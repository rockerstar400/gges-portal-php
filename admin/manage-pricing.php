<?php 
require_once 'includes/auth_check.php';
require_once '../functions.php';
$plans = getPricing(); 
include('includes/header.php'); 
include('includes/sidebar.php'); 
?>

<div class="content-area">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold m-0">Pricing</h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb m-0 small">
                <li class="breadcrumb-item"><a href="dashboard.php" class="text-decoration-none text-muted">Home</a></li>
                <li class="breadcrumb-item active fw-bold text-dark">Pricing</li>
            </ol>
        </nav>
    </div>

    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-header bg-white border-bottom py-3">
            <h6 class="fw-bold m-0 text-muted">Pricing List</h6>
        </div>
        <div class="card-body p-4">
            <!-- FIX: Button ki ID 'pricingModal' se hata di hai -->
            <button type="button" class="btn btn-primary px-4 py-2 rounded-3 fw-bold mb-4 shadow-blue" data-bs-toggle="modal" data-bs-target="#addPricingModal">
                + Add Pricing
            </button>

            <div class="table-responsive">
                <table class="table align-middle custom-table">
                    <thead class="table-light">
                        <tr>
                            <th class="border-0 ps-4">#</th>
                            <th class="border-0">Image</th>
                            <th class="border-0">Class Name</th>
                            <th class="border-0">Plan</th>
                            <th class="border-0">Fees</th>
                            <th class="border-0">Fee / Hour</th>
                            <th class="border-0 text-end pe-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if($plans): foreach($plans as $index => $p): 
                            $feesList = json_decode($p['fees'], true);
                        ?>
                        <tr>
                            <td class="ps-4 text-muted small"><?php echo $index + 1; ?></td>
                            <td><img src="../<?php echo $p['image']; ?>" class="rounded shadow-sm" width="55" height="45" style="object-fit: cover;"></td>
                            <td class="text-dark small fw-bold text-uppercase"><?php echo $p['className']; ?></td>
                            <td class="text-dark small fw-bold text-uppercase"><?php echo $p['planName']; ?></td>
                            <td class="small">
                                <?php if($feesList): foreach($feesList as $f): ?>
                                    <div class="text-muted text-uppercase mb-1" style="font-size: 11px;">
                                        <?php echo $f['label']; ?>: <span class="fw-bold text-dark">$ <?php echo $f['price']; ?></span>
                                    </div>
                                <?php endforeach; endif; ?>
                            </td>
                            <td class="fw-bold text-dark">$ <?php echo $p['feesPerHour']; ?></td>
                            <td class="text-end pe-4">
                                <div class="d-flex justify-content-end gap-2">
                                    <a href="../api/admin/manage-pricing.php?action=delete&id=<?php echo $p['id']; ?>" 
                                       class="btn btn-sm text-danger p-1" onclick="return confirm('Delete this plan?')">
                                        <i class="fas fa-trash-alt fs-5"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; else: ?>
                        <tr><td colspan="7" class="text-center py-5 text-muted">No pricing plans found</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- --- ADD PRICING MODAL (Fixed ID) --- -->
<div class="modal fade" id="addPricingModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 rounded-4 shadow-lg">
            <div class="modal-header border-0 pb-0 pe-4 pt-4">
                <h5 class="modal-title fw-bold">Add Pricing</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="../api/admin/manage-pricing.php?action=add" method="POST" enctype="multipart/form-data">
                <div class="modal-body p-4">
                    
                    <!-- Upload Image -->
                    <div class="mb-3">
                        <label class="upload-box-dashed w-100">
                            <input type="file" name="image" hidden onchange="previewPricingImg(this)" required>
                            <div class="text-center py-3" id="upPlaceholder">
                                <i class="fas fa-cloud-upload-alt text-primary fa-2x mb-2"></i>
                                <p class="small fw-bold text-dark m-0">Click to Upload Image</p>
                            </div>
                            <img id="pricingPreview" class="d-none w-100 h-100 object-fit-contain rounded-3">
                        </label>
                    </div>

                    <!-- Inputs -->
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <input type="text" name="className" class="form-control custom-input" placeholder="Enter class name" required>
                        </div>
                        <div class="col-md-6">
                            <input type="text" name="planName" class="form-control custom-input" placeholder="Plan name" required>
                        </div>
                    </div>

                    <!-- Dynamic Fees -->
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <label class="fw-bold m-0 small">Fees (List)</label>
                        <button type="button" onclick="addFeeRow()" class="btn btn-link text-decoration-none fw-bold p-0 small">+ Add Fee</button>
                    </div>
                    
                    <div id="fees-container">
                        <div class="row g-2 mb-2 align-items-center">
                            <div class="col-md-7"><input type="text" name="fee_labels[]" class="form-control custom-input" placeholder="Label" required></div>
                            <div class="col-md-4"><input type="text" name="fee_prices[]" class="form-control custom-input" placeholder="Price" required></div>
                            <div class="col-md-1"></div>
                        </div>
                    </div>

                    <div class="row g-3 mt-1 mb-4">
                        <div class="col-md-6"><input type="text" name="feesPerHour" class="form-control custom-input" placeholder="Fee per hour ($)"></div>
                        <div class="col-md-6"><input type="text" name="off" class="form-control custom-input" placeholder="Off (%)"></div>
                    </div>

                    <button type="submit" class="btn btn-primary w-100 py-3 rounded-3 fw-bold">Save Pricing Plan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
.upload-box-dashed { border: 2px dashed #305CDE; border-radius: 12px; background: #fcfdff; cursor: pointer; min-height: 120px; display: flex; align-items: center; justify-content: center; position: relative; overflow: hidden;}
.custom-input { border: 1px solid #e0e6ed; border-radius: 10px; padding: 12px 15px; font-size: 14px; }
.shadow-blue { box-shadow: 0 10px 20px rgba(48, 92, 222, 0.2) !important; }
</style>

<script>
    function previewPricingImg(input) {
        const preview = document.getElementById('pricingPreview');
        const placeholder = document.getElementById('upPlaceholder');
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = e => {
                preview.src = e.target.result;
                preview.classList.remove('d-none');
                placeholder.classList.add('d-none');
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    function addFeeRow() {
        const container = document.getElementById('fees-container');
        const row = document.createElement('div');
        row.className = 'row g-2 mb-2 align-items-center';
        row.innerHTML = `
            <div class="col-md-7"><input type="text" name="fee_labels[]" class="form-control custom-input" placeholder="Label" required></div>
            <div class="col-md-4"><input type="text" name="fee_prices[]" class="form-control custom-input" placeholder="Price" required></div>
            <div class="col-md-1"><button type="button" class="btn text-danger remove-row"><i class="fas fa-minus-circle"></i></button></div>
        `;
        container.appendChild(row);
    }

    document.addEventListener('click', e => {
        if(e.target.closest('.remove-row')) e.target.closest('.row').remove();
    });
</script>

<?php include('includes/footer.php'); ?>
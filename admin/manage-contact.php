<?php 
require_once 'includes/auth_check.php';
require_once '../functions.php';

// Database se data fetch karein
$contact = getContactInfo(); 
$queries = getAll('contact_queries');

include('includes/header.php'); 
include('includes/sidebar.php'); 
?>

<div class="content-area">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold m-0">Contact Management</h3>
    </div>

    <div class="card border-0 shadow-sm rounded-4">
        <!-- Tabs Headers -->
        <div class="card-header bg-white border-0 pt-4 px-4">
            <ul class="nav nav-tabs border-0 custom-tabs" id="contactTab" role="tablist">
                <li class="nav-item">
                    <button class="nav-link active fw-bold" id="list-tab" data-bs-toggle="tab" data-bs-target="#list-pane" type="button" role="tab">Contact List</button>
                </li>
                <li class="nav-item">
                    <button class="nav-link fw-bold ms-4" id="text-tab" data-bs-toggle="tab" data-bs-target="#text-pane" type="button" role="tab">Contact Text</button>
                </li>
            </ul>
        </div>

        <div class="card-body p-4">
            <div class="tab-content" id="contactTabContent">
                
                <!-- Tab 1: Contact List (Messages) -->
                <!-- <div class="tab-pane fade show active" id="list-pane" role="tabpanel">
                    <div class="table-responsive">
                        <table class="table align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Mobile</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if($queries): foreach($queries as $q): ?>
                                <tr>
                                    <td><?php echo $q['name']; ?></td>
                                    <td><?php echo $q['email']; ?></td>
                                    <td><?php echo $q['mobile']; ?></td>
                                    <td><?php echo date('d M Y', strtotime($q['created_at'])); ?></td>
                                </tr>
                                <?php endforeach; else: ?>
                                    <tr><td colspan="4" class="text-center py-4">No messages found</td></tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div> -->
                <!-- Tab 1: Contact List (Messages from Users) -->
<div class="tab-pane fade show active" id="list-pane" role="tabpanel">
    <div class="table-responsive">
        <table class="table align-middle">
            <thead class="table-light">
                <tr>
                    <th class="border-0">Name</th>
                    <th class="border-0">Email</th>
                    <th class="border-0">Mobile</th>
                    <th class="border-0">Message</th> <!-- Naya Column -->
                    <th class="border-0">Date</th>
                </tr>
            </thead>
            <tbody>
                <?php if($queries): foreach($queries as $q): ?>
                <tr>
                    <td class="fw-bold text-dark"><?php echo $q['name']; ?></td>
                    <td class="text-muted"><?php echo $q['email']; ?></td>
                    <td><?php echo $q['mobile']; ?></td>
                    
                    <!-- Message Logic: Chota karke dikhayenge taaki table clean rahe -->
                    <td class="small text-muted">
                        <div style="max-width: 250px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;" title="<?php echo $q['message']; ?>">
                            <?php echo $q['message']; ?>
                        </div>
                    </td>

                    <td class="small text-muted"><?php echo date('d M Y', strtotime($q['created_at'])); ?></td>
                </tr>
                <?php endforeach; else: ?>
                    <!-- Colspan ab 5 hoga kyunki 5 columns hain -->
                    <tr><td colspan="5" class="text-center py-4">No messages found</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

                <!-- Tab 2: Contact Text (Settings) -->
                <div class="tab-pane fade" id="text-pane" role="tabpanel">
                    <div class="mt-2">
                        <?php if(!$contact): ?>
                            <div class="alert alert-danger">Failed to load Contact data. Please check database.</div>
                        <?php else: ?>
                            <form action="../api/admin/manage-contact.php" method="POST">
                                <div class="mb-3">
                                    <label class="fw-bold small text-muted">Description</label>
                                    <textarea name="description" class="form-control custom-input" rows="4"><?php echo $contact['description']; ?></textarea>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="fw-bold small text-muted">Mobile</label>
                                        <input type="text" name="mobile" class="form-control custom-input" value="<?php echo $contact['mobile']; ?>">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="fw-bold small text-muted">Email</label>
                                        <input type="email" name="email" class="form-control custom-input" value="<?php echo $contact['email']; ?>">
                                    </div>
                                </div>
                                <div class="mb-4">
                                    <label class="fw-bold small text-muted">Address</label>
                                    <textarea name="address" class="form-control custom-input" rows="2"><?php echo $contact['address']; ?></textarea>
                                </div>
                                <button type="submit" class="btn btn-primary w-100 py-3 rounded-3 fw-bold shadow-blue">Save Changes</button>
                            </form>
                        <?php endif; ?>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<style>
/* Screenshot accurate styles */
.custom-tabs .nav-link { color: #6c757d; border: none; background: none !important; padding-bottom: 10px; }
.custom-tabs .nav-link.active { color: #305CDE; border-bottom: 3px solid #305CDE !important; }
.custom-input { border: 1px solid #e0e6ed; border-radius: 10px; padding: 12px; }
.shadow-blue { box-shadow: 0 8px 15px rgba(48, 92, 222, 0.2); }
</style>

<?php include('includes/footer.php'); ?>
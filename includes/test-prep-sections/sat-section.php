<?php 
/**
 * SECTION: SAT FRONTEND (MATCHING REACT DESIGN)
 * Variables: $sectionData (from Master Fetch)
 */

// Mapping variables as per React State & Master Function
$heroTitle       = $sectionData['hero']['title'] ?? "SAT TEST PREP";
$heroSubtitle    = $sectionData['hero']['subtitle'] ?? "";
$heroDescription = $sectionData['hero']['description'] ?? "";

$aboutHeading     = $sectionData['about']['heading'] ?? "ALL ABOUT SAT";
$aboutDescription = $sectionData['about']['description'] ?? "";
$tableData        = $sectionData['table'] ?? []; // table_data_json becomes 'table'
?>

<style>
    /* React Style Theme */
    .sat-wrapper { 
        background-color: #F0F8FF; 
        background-image: url('assets/images/math-bg.png'); 
        background-size: contain; 
        background-position: center; 
        background-repeat: no-repeat;
        min-height: 100vh;
        font-family: 'Inter', sans-serif;
    }

    .btn-react-blue {
        background-color: #2563eb;
        color: white !important;
        font-weight: 600;
        padding: 12px 24px;
        border-radius: 8px;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        transition: all 0.3s;
        border: none;
        text-decoration: none;
        display: inline-block;
    }

    .btn-react-blue:hover {
        background-color: #1d4ed8;
        transform: scale(1.05);
        box-shadow: 0 10px 15px -3px rgba(37, 99, 235, 0.3);
    }

    /* 3D Lift Effect on Hover (Replicating React's cardHover3D) */
    .card-3d-sat {
        background: #F0F8FF;
        border-radius: 12px;
        padding: 2.5rem;
        border: 1px solid #dbeafe;
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        transition: all 0.6s cubic-bezier(0.165, 0.84, 0.44, 1);
    }

    .card-3d-sat:hover {
        transform: translateY(-10px);
        box-shadow: 0px 25px 50px -12px rgba(37, 99, 235, 0.25) !important;
    }

    /* Table Styling */
    .sat-table { border-collapse: separate; border-spacing: 0; width: 100%; border-radius: 8px; overflow: hidden; }
    .sat-table thead { background-color: #2563eb; color: white; }
    .sat-table th { padding: 15px; font-weight: 600; border: 1px solid #dee2e6; }
    .sat-table td { padding: 12px; border: 1px solid #dee2e6; }
    .bg-gray-row { background-color: #f3f4f6; }
    .bg-white-row { background-color: #ffffff; }
    .hover-row:hover { background-color: #eff6ff; }
</style>

<div class="sat-wrapper py-5 px-3">
    <div class="container py-4 max-w-7xl mx-auto">

        <!-- ================= 1. HERO SECTION ================= -->
        <div class="text-center mb-5" data-aos="fade-up">
            <h1 class="display-4 fw-bold text-dark mb-4"><?= $heroTitle ?></h1>
            <?php if($heroSubtitle): ?>
                <p class="fs-5 text-secondary mx-auto mb-4" style="max-width: 850px;">
                    <?= $heroSubtitle ?>
                </p>
            <?php endif; ?>
        </div>

        <!-- ================= 2. MAIN CONTENT ================= -->
        <div class="row justify-content-center mb-5" data-aos="fade-up" data-aos-delay="200">
            <div class="col-lg-11 text-center">
                <div class="text-start fs-5 text-dark lh-lg mb-5" style="white-space: pre-line;">
                    <?= $heroDescription ?>
                </div>
                
                <div class="text-center">
                    <a href="contact.php" class="btn-react-blue">Click here for Free Trial Class</a>
                </div>
            </div>
        </div>

        <!-- ================= 3. ABOUT & TABLE SECTION (3D Hover Card) ================= -->
        <div class="card-3d-sat mt-5" data-aos="zoom-in" data-aos-delay="300">
            <h2 class="text-center fw-bold text-dark mb-4 text-uppercase h1"><?= $aboutHeading ?></h2>
            
            <p class="text-secondary fs-5 text-center mb-5 mx-auto" style="max-width: 1000px; white-space: pre-line;">
                <?= $aboutDescription ?>
            </p>

            <!-- Table -->
            <div class="table-responsive rounded-3 shadow-sm border border-gray-300">
                <table class="sat-table align-middle mb-0">
                    <thead>
                        <tr>
                            <th>Component</th>
                            <th class="text-center">Time Allowed (minutes)</th>
                            <th class="text-center">Number of Question/Tasks</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(!empty($tableData)): ?>
                            <?php foreach($tableData as $index => $row): ?>
                            <tr class="<?= $index % 2 === 0 ? 'bg-white-row' : 'bg-gray-row' ?> hover-row transition">
                                <td class="p-3 fw-bold text-dark"><?= $row['name'] ?></td>
                                <td class="p-3 text-center"><?= $row['time'] ?></td>
                                <td class="p-3 text-center"><?= $row['modules'] ?></td>
                            </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr><td colspan="3" class="text-center py-4">No Data Available</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <div class="text-center mt-5">
                <a href="contact.php" class="btn-react-blue px-5 py-3 shadow-lg">Click here for Free Trial Class</a>
            </div>
        </div>
    </div>
</div>
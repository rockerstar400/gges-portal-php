<?php
require_once 'config/db.php';



// function uploadFile($file, $targetDir = "uploads/") {
   
//     if (!$file || !isset($file['tmp_name']) || empty($file['tmp_name'])) {
//         return null;
//     }

//     if (!is_dir("../../" . $targetDir)) mkdir("../../" . $targetDir, 0777, true);
    
//     $fileName = time() . '_' . basename($file["name"]);
//     $targetPath = $targetDir . $fileName;
    
//     if (move_uploaded_file($file["tmp_name"], "../../" . $targetPath)) {
//         return $targetPath;
//     }
//     return null;
// }

function uploadFile($file, $targetDir = "uploads/") {
    // 1. Safety Check
    if (!$file || !isset($file['tmp_name']) || empty($file['tmp_name'])) {
        return null;
    }

    // 2. Absolute Path nikalna (functions.php ke location ke hisaab se)
    // __DIR__ matlab jahan functions.php hai. 
    // Agar functions.php root mein hai toh ye project root ban jayega.
    $basePath = __DIR__ . DIRECTORY_SEPARATOR; 
    $fullTargetDir = $basePath . $targetDir;

    // 3. Folder check aur creation
    if (!is_dir($fullTargetDir)) {
        mkdir($fullTargetDir, 0777, true);
    }
    
    // 4. File name aur path taiyar karna
    $fileName = time() . '_' . basename($file["name"]);
    $destination = $fullTargetDir . $fileName;
    
    // 5. File upload process
    if (move_uploaded_file($file["tmp_name"], $destination)) {
        // Database mein relative path save hoga: "uploads/12345_image.jpg"
        return $targetDir . $fileName; 
    }

    return null;
}

// --- 2. DATABASE GENERAL FUNCTIONS ---

// Database se saara data lane ke liye
function getAll($table) {
    global $conn;
    try {
        $stmt = $conn->prepare("SELECT * FROM $table ORDER BY id DESC");
        $stmt->execute();
        return $stmt->fetchAll();
    } catch(PDOException $e) {
        return [];
    }
}

// Sirf limited data lane ke liye (e.g. Latest 1 banner ya Latest 3 blogs)
function getLatest($table, $limit = 3) {
    global $conn;
    try {
        $stmt = $conn->prepare("SELECT * FROM $table ORDER BY id DESC LIMIT :limit");
        $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    } catch(PDOException $e) {
        return [];
    }
}

// --- 3. BANNER SPECIFIC FUNCTIONS ---

// Get single banner for Hero section
function getBanner() {
    global $conn;
    try {
        $stmt = $conn->prepare("SELECT * FROM banners LIMIT 1");
        $stmt->execute();
        return $stmt->fetch();
    } catch(PDOException $e) {
        return null;
    }
}

// Add or Update Banner (Used in Admin)
function saveBanner($title, $description, $file = null) {
    global $conn;
    $existing = getBanner();
    $imagePath = $existing ? $existing['image'] : null;

    if ($file && $file['tmp_name']) {
        if ($imagePath && file_exists($imagePath)) {
            unlink($imagePath);
        }
        $imagePath = uploadFile($file);
    }

    if ($existing) {
        $sql = "UPDATE banners SET title = ?, description = ?, image = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        return $stmt->execute([$title, $description, $imagePath, $existing['id']]);
    } else {
        $sql = "INSERT INTO banners (title, description, image) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        return $stmt->execute([$title, $description, $imagePath]);
    }
}

// --- 4. CONTACT FORM FUNCTIONS ---

function saveContact($data) {
    global $conn;
    try {
        $sql = "INSERT INTO contact_queries (name, email, mobile, message) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        return $stmt->execute([$data['name'], $data['email'], $data['mobile'], $data['message']]);
    } catch(PDOException $e) {
        return false;
    }
}


// --- WHY CHOOSE US FUNCTIONS ---

// 1. Add New Why Choose Item
function addWhyChoose($title, $description, $file) {
    global $conn;
    $imagePath = uploadFile($file); // Pehle function banaya tha wahi use hoga
    
    if (!$imagePath) return false;

    $sql = "INSERT INTO why_choose (title, description, image) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    return $stmt->execute([$title, $description, $imagePath]);
}

// 2. Update Why Choose Item
function updateWhyChoose($id, $title, $description, $file = null) {
    global $conn;
    
    // Purana data nikalo image check karne ke liye
    $stmt = $conn->prepare("SELECT image FROM why_choose WHERE id = ?");
    $stmt->execute([$id]);
    $existing = $stmt->fetch();
    
    $imagePath = $existing['image'];

    if ($file && $file['tmp_name']) {
        // Purani image delete karo
        if (file_exists($imagePath)) unlink($imagePath);
        $imagePath = uploadFile($file);
    }

    $sql = "UPDATE why_choose SET title = ?, description = ?, image = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    return $stmt->execute([$title, $description, $imagePath, $id]);
}

// 3. Delete Why Choose Item
function deleteWhyChoose($id) {
    global $conn;
    $stmt = $conn->prepare("SELECT image FROM why_choose WHERE id = ?");
    $stmt->execute([$id]);
    $existing = $stmt->fetch();

    if ($existing) {
        if (file_exists($existing['image'])) unlink($existing['image']);
        $stmt = $conn->prepare("DELETE FROM why_choose WHERE id = ?");
        return $stmt->execute([$id]);
    }
    return false;
}

// --- OFFERS FUNCTIONS ---

// 1. Get All Offers (Public)
function getOffers() {
    global $conn;
    $stmt = $conn->prepare("SELECT * FROM offers ORDER BY created_at DESC");
    $stmt->execute();
    return $stmt->fetchAll();
}

// 2. Get Single Offer Detail (By ID)
function getOfferById($id) {
    global $conn;
    $stmt = $conn->prepare("SELECT * FROM offers WHERE id = ?");
    $stmt->execute([$id]);
    return $stmt->fetch();
}

// 3. Add New Offer (Admin)
function addOffer($data) {
    global $conn;
    $sql = "INSERT INTO offers (type, title, description, expireDate) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    return $stmt->execute([$data['type'], $data['title'], $data['description'], $data['expireDate']]);
}

// 4. Update Offer (Admin)
function updateOffer($id, $data) {
    global $conn;
    $sql = "UPDATE offers SET type = ?, title = ?, description = ?, expireDate = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    return $stmt->execute([$data['type'], $data['title'], $data['description'], $data['expireDate'], $id]);
}

// 5. Delete Offer (Admin)
function deleteOffer($id) {
    global $conn;
    $stmt = $conn->prepare("DELETE FROM offers WHERE id = ?");
    return $stmt->execute([$id]);
}

// trust
// --- TRUST & CREDIBILITY FUNCTIONS ---

// 1. Get All Trust Items (Public)
function getTrustData() {
    global $conn;
    // Node.js ke sort({ createdAt: -1 }) ke liye:
    $stmt = $conn->prepare("SELECT * FROM trust ORDER BY created_at DESC");
    $stmt->execute();
    return $stmt->fetchAll();
}

// 2. Add Trust Item (Admin)
function addTrust($title, $description, $file) {
    global $conn;
    $imagePath = uploadFile($file); // Humara banaya hua helper function
    if (!$imagePath) return false;

    $sql = "INSERT INTO trust (title, description, image) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    return $stmt->execute([$title, $description, $imagePath]);
}

// 3. Delete Trust Item (Admin)
function deleteTrust($id) {
    global $conn;
    $stmt = $conn->prepare("SELECT image FROM trust WHERE id = ?");
    $stmt->execute([$id]);
    $item = $stmt->fetch();
    if ($item) {
        if (file_exists($item['image'])) unlink($item['image']);
        $stmt = $conn->prepare("DELETE FROM trust WHERE id = ?");
        return $stmt->execute([$id]);
    }
    return false;
}

// --- PRICING FUNCTIONS ---

// 1. Get All Pricing Plans (Public)
function getPricing() {
    global $conn;
    $stmt = $conn->prepare("SELECT * FROM pricing ORDER BY created_at DESC");
    $stmt->execute();
    return $stmt->fetchAll();
}

// 2. Add Pricing (Admin)
// function addPricing($data, $file) {
//     global $conn;
//     $imagePath = uploadFile($file);
//     if (!$imagePath) return false;

//     // Fees array ko JSON string mein badalna (Node.js JSON.parse jaisa)
//     $feesJson = json_encode($data['fees']);

//     $sql = "INSERT INTO pricing (planName, className, fees, feesPerHour, off, image) VALUES (?, ?, ?, ?, ?, ?)";
//     $stmt = $conn->prepare($sql);
//     return $stmt->execute([
//         $data['planName'], 
//         $data['className'], 
//         $feesJson, 
//         $data['feesPerHour'], 
//         $data['off'], 
//         $imagePath
//     ]);
// }

// --- ABOUT US LOGIC ---
function getAbout() {
    global $conn;
    $stmt = $conn->prepare("SELECT * FROM about LIMIT 1");
    $stmt->execute();
    return $stmt->fetch();
}

// function upsertAbout($data, $file = null) {
//     global $conn;
//     $existing = getAbout();
//     $imagePath = $existing ? $existing['image'] : null;

//     if ($file && $file['tmp_name']) {
//         if ($imagePath && file_exists($imagePath)) unlink($imagePath);
//         $imagePath = uploadFile($file);
//     }

//     // Arrays ko JSON string mein badalna (MongoDB array format match karne ke liye)
//     $desc = json_encode($data['description']);
//     $whyUs = json_encode($data['whyUsDescription']);
//     $howDiff = json_encode($data['howDiffrentDescription']);
//     $safety = json_encode($data['safetyDescription']);

//     if ($existing) {
//         $sql = "UPDATE about SET image=?, description=?, why_us=?, how_different=?, safety=?, tutor_desc=?, how_diff_header=? WHERE id=?";
//         $stmt = $conn->prepare($sql);
//         return $stmt->execute([$imagePath, $desc, $whyUs, $howDiff, $safety, $data['tutorDescription'], $data['howDiffrentHeader'], $existing['id']]);
//     } else {
//         $sql = "INSERT INTO about (image, description, why_us, how_different, safety, tutor_desc, how_diff_header) VALUES (?,?,?,?,?,?,?)";
//         $stmt = $conn->prepare($sql);
//         return $stmt->execute([$imagePath, $desc, $whyUs, $howDiff, $safety, $data['tutorDescription'], $data['howDiffrentHeader']]);
//     }
// }

// --- MANAGEMENT LOGIC ---
function getMembers() {
    global $conn;
    // Node.js: .sort({ order: 1, createdAt: 1 })
    $stmt = $conn->prepare("SELECT * FROM management ORDER BY order_val ASC, created_at ASC");
    $stmt->execute();
    return $stmt->fetchAll();
}

// function addMember($name, $role, $desc, $order, $file) {
//     global $conn;
//     $imagePath = uploadFile($file);
//     $sql = "INSERT INTO management (name, role, description, image, order_val) VALUES (?, ?, ?, ?, ?)";
//     $stmt = $conn->prepare($sql);
//     return $stmt->execute([$name, $role, $desc, $imagePath, $order]);
// }

function getContactInfo() {
    global $conn;
    try {
        $stmt = $conn->prepare("SELECT * FROM contact_info LIMIT 1");
        $stmt->execute();
        return $stmt->fetch();
    } catch(PDOException $e) {
        return null;
    }
}
// --- BLOG FUNCTIONS ---

// 1. Get All Blogs (Public)
function getBlogs() {
    global $conn;
    $stmt = $conn->query("SELECT * FROM blogs ORDER BY created_at DESC");
    return $stmt->fetchAll();
}

function getBlogById($id) {
    global $conn;
    $stmt = $conn->prepare("SELECT * FROM blogs WHERE id = ?");
    $stmt->execute([$id]);
    return $stmt->fetch();
}

// 3. Add Blog (Admin)
function addBlog($title, $description, $type, $files) {
    global $conn;
    $imagePath = null;
    $videoPath = null;

    // Conditionally handle Image or Video based on Type
    if ($type === "image" && isset($files['image'])) {
        $imagePath = uploadFile($files['image']);
    } elseif ($type === "video" && isset($files['video'])) {
        $videoPath = uploadFile($files['video']);
    }

    $sql = "INSERT INTO blogs (title, description, type, image, video) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    return $stmt->execute([$title, $description, $type, $imagePath, $videoPath]);
}

// --- TESTIMONIAL FUNCTIONS ---

// 1. Add New Testimonial (Admin)
function addTestimonial($title, $description, $address, $file) {
    global $conn;
    
    // Image validation (Node.js !req.file jaisa)
    if (!$file || empty($file['name'])) return false;

    $imagePath = uploadFile($file);
    if (!$imagePath) return false;

    $sql = "INSERT INTO testimonials (title, description, address, image) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    return $stmt->execute([$title, $description, $address, $imagePath]);
}

// 2. Delete Testimonial (Admin)
function deleteTestimonial($id) {
    global $conn;
    
    // Image unlink logic
    $stmt = $conn->prepare("SELECT image FROM testimonials WHERE id = ?");
    $stmt->execute([$id]);
    $item = $stmt->fetch();
    
    if ($item) {
        $fullPath = "../../" . $item['image'];
        if (file_exists($fullPath)) unlink($fullPath);
        
        $stmt = $conn->prepare("DELETE FROM testimonials WHERE id = ?");
        return $stmt->execute([$id]);
    }
    return false;
}
// Node.js ke find().sort({ createdAt: -1 }) ka PHP version
function getTestimonials() {
    global $conn;
    try {
        $stmt = $conn->prepare("SELECT * FROM testimonials ORDER BY created_at DESC");
        $stmt->execute();
        return $stmt->fetchAll();
    } catch(PDOException $e) {
        return [];
    }
}


// --- MANAGEMENT TEAM FUNCTIONS ---

// 1. Add Member (Node.js addMember jaisa)
function addMember($name, $role, $description, $order, $file) {
    global $conn;
    
    if (!$file || empty($file['name'])) return false;

    // File upload logic
    $rawPath = uploadFile($file);
    if (!$rawPath) return false;

    // Node.js replacement logic: .replace(/\\/g, "/")
    $imagePath = str_replace('\\', '/', $rawPath);

    $sql = "INSERT INTO management (name, role, description, image, order_val) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    return $stmt->execute([$name, $role, $description, $imagePath, $order]);
}

// 2. Update Member (Node.js patch jaisa)
function updateMember($id, $name, $role, $description, $order, $file = null) {
    global $conn;
    
    // Purana data nikalo image check karne ke liye
    $stmt = $conn->prepare("SELECT image FROM management WHERE id = ?");
    $stmt->execute([$id]);
    $existing = $stmt->fetch();
    $imagePath = $existing['image'];

    if ($file && !empty($file['name'])) {
        // Purani image delete karo
        if (file_exists("../../" . $imagePath)) unlink("../../" . $imagePath);
        
        $rawPath = uploadFile($file);
        $imagePath = str_replace('\\', '/', $rawPath);
    }

    $sql = "UPDATE management SET name=?, role=?, description=?, image=?, order_val=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    return $stmt->execute([$name, $role, $description, $imagePath, $order, $id]);
}
// --- PRICING FUNCTIONS ---

function addPricing($data, $file) {
    global $conn;
    
    // 1. Image Upload
    if (!$file || empty($file['name'])) return false;
    $imagePath = uploadFile($file);
    if (!$imagePath) return false;

    // 2. Fees Array to JSON (Exactly like Node.js storage)
    $feesJson = json_encode($data['fees']);

    $sql = "INSERT INTO pricing (planName, className, fees, feesPerHour, off, image) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    return $stmt->execute([
        $data['planName'],
        $data['className'],
        $feesJson,
        $data['feesPerHour'],
        $data['off'],
        $imagePath
    ]);
}

// --- ABOUT US UPSERT LOGIC ---
function upsertAbout($data, $file = null) {
    global $conn;
    
    // 1. Check if record exists
    $stmt = $conn->query("SELECT * FROM about LIMIT 1");
    $existing = $stmt->fetch();
    $imagePath = $existing ? $existing['image'] : null;

    // 2. Handle Image (Replace old or upload new)
    if ($file && !empty($file['name'])) {
        if ($imagePath && file_exists("../../" . $imagePath)) {
            unlink("../../" . $imagePath);
        }
        $imagePath = uploadFile($file);
    }

    // 3. Prepare Arrays as JSON strings (Exactly like Node.js [String])
    $description = json_encode($data['description'] ?? []);
    $whyUs = json_encode($data['whyUsDescription'] ?? []);
    $howDiff = json_encode($data['howDiffrentDescription'] ?? []);
    $safety = json_encode($data['safetyDescription'] ?? []);

    if ($existing) {
        // UPDATE Logic
        $sql = "UPDATE about SET 
                image = ?, description = ?, why_us = ?, 
                how_different = ?, safety = ?, tutor_desc = ?, 
                how_diff_header = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        return $stmt->execute([
            $imagePath, $description, $whyUs, 
            $howDiff, $safety, $data['tutorDescription'], 
            $data['howDiffrentHeader'], $existing['id']
        ]);
    } else {
        // CREATE Logic
        if (!$imagePath) return false; // Image required for new record
        $sql = "INSERT INTO about (image, description, why_us, how_different, safety, tutor_desc, how_diff_header) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        return $stmt->execute([
            $imagePath, $description, $whyUs, 
            $howDiff, $safety, $data['tutorDescription'], 
            $data['howDiffrentHeader']
        ]);
    }
}

// --- SUCCESS STORIES FUNCTIONS ---

function getSuccessStories() {
    global $conn;
    $stmt = $conn->query("SELECT * FROM success_stories ORDER BY created_at DESC");
    return $stmt->fetchAll();
}

function addStory($name, $designation, $description, $rating, $file) {
    global $conn;
    $imagePath = uploadFile($file);
    if (!$imagePath) return false;

    $sql = "INSERT INTO success_stories (name, designation, description, rating, image) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    return $stmt->execute([$name, $designation, $description, $rating, $imagePath]);
}

function getTrustStats() {
    global $conn;
    $stmt = $conn->query("SELECT * FROM trust_stats ORDER BY created_at DESC");
    return $stmt->fetchAll();
}

function saveTrust($title, $description, $file, $id = null) {
    global $conn;
    $imagePath = null;

    // Edit case mein purani image dhoondein
    if ($id) {
        $stmt = $conn->prepare("SELECT image FROM trust_stats WHERE id = ?");
        $stmt->execute([$id]);
        $existing = $stmt->fetch();
        $imagePath = $existing['image'];
    }

    // Nayi image aayi hai toh upload karein
    if ($file && !empty($file['name'])) {
        if ($imagePath && file_exists("../../" . $imagePath)) unlink("../../" . $imagePath);
        $imagePath = uploadFile($file);
    }

    if ($id) {
        $sql = "UPDATE trust_stats SET title=?, description=?, image=? WHERE id=?";
        $stmt = $conn->prepare($sql);
        return $stmt->execute([$title, $description, $imagePath, $id]);
    } else {
        $sql = "INSERT INTO trust_stats (title, description, image) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        return $stmt->execute([$title, $description, $imagePath]);
    }
}
// --- FOOTER BANNER FUNCTIONS ---

function getFooterBanner() {
    global $conn;
    $stmt = $conn->query("SELECT * FROM footer_banner LIMIT 1");
    return $stmt->fetch();
}

function upsertFooterBanner($title, $description, $file = null) {
    global $conn;
    $existing = getFooterBanner();
    $imagePath = $existing ? $existing['image'] : null;

    // Image replacement logic (Node.js fs.unlinkSync jaisa)
    if ($file && !empty($file['name'])) {
        if ($imagePath && file_exists("../../" . $imagePath)) {
            unlink("../../" . $imagePath);
        }
        $imagePath = uploadFile($file);
    }

    if ($existing) {
        $sql = "UPDATE footer_banner SET title = ?, description = ?, image = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        return $stmt->execute([$title, $description, $imagePath, $existing['id']]);
    } else {
        $sql = "INSERT INTO footer_banner (title, description, image) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        return $stmt->execute([$title, $description, $imagePath]);
    }
}


// --- COURSE SECTIONS LOGIC ---

function getCourseData($slug) {
    global $conn;
    $stmt = $conn->prepare("SELECT * FROM course_sections WHERE category_slug = ?");
    $stmt->execute([$slug]);
    return $stmt->fetch();
}

function upsertCourseData($slug, $title, $description) {
    global $conn;
    $existing = getCourseData($slug);
    $descJson = json_encode($description);

    if ($existing) {
        $sql = "UPDATE course_sections SET title = ?, description = ? WHERE category_slug = ?";
        $stmt = $conn->prepare($sql);
        return $stmt->execute([$title, $descJson, $slug]);
    } else {
        $sql = "INSERT INTO course_sections (category_slug, title, description) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        return $stmt->execute([$slug, $title, $descJson]);
    }
}


// Kangaroo Details fetch karne ke liye
function getKangarooDetails() {
    global $conn;
    $stmt = $conn->query("SELECT * FROM kangaroo_details ORDER BY id ASC");
    return $stmt->fetchAll();
}

// Kangaroo Detail add karne ke liye
function addKangarooDetail($title, $descriptions, $file) {
    global $conn;
    // Helper function se image upload karein
    $imagePath = uploadFile($file);
    if (!$imagePath) return false;
    
    // Node.js array ko MySQL JSON string mein badlein
    $descJson = json_encode($descriptions);
    
    $sql = "INSERT INTO kangaroo_details (title, description, image) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    return $stmt->execute([$title, $descJson, $imagePath]);
}



// --- SCIENCE DETAILS FUNCTIONS ---
function getScienceDetails() {
    global $conn;
    $stmt = $conn->query("SELECT * FROM science_details ORDER BY id ASC");
    return $stmt->fetchAll();
}

function addScienceDetail($title, $heading, $description, $file) {
    global $conn;
    $imagePath = uploadFile($file);
    if (!$imagePath) return false;
    
    $sql = "INSERT INTO science_details (title, heading, description, image) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    return $stmt->execute([$title, $heading, $description, $imagePath]);
}

// functions.php mein ye upgrade karein (agar nahi hai toh)
function uploadCourseFile($file, $prefix = "k12") {
    if (!$file || empty($file['name'])) return null;
    $targetDir = "uploads/";
    $uploadPath = dirname(__DIR__) . DIRECTORY_SEPARATOR . $targetDir;
    
    $fileName = $prefix . "_" . time() . "_" . basename($file["name"]);
    if (move_uploaded_file($file["tmp_name"], $uploadPath . $fileName)) {
        return $targetDir . $fileName;
    }
    return null;
}


// --- K-12 METHODOLOGY FUNCTIONS ---
function getK12Methodology() {
    global $conn;
    return $conn->query("SELECT * FROM k12_methodology ORDER BY id DESC")->fetchAll();
}

function addK12Methodology($title, $desc, $file) {
    global $conn;
    $imagePath = uploadFile($file);
    if (!$imagePath) return false;
    $stmt = $conn->prepare("INSERT INTO k12_methodology (title, description, image) VALUES (?, ?, ?)");
    return $stmt->execute([$title, $desc, $imagePath]);
}

function getEnglishDetails($slug) {
    global $conn;
    $stmt = $conn->prepare("SELECT * FROM english_details WHERE category_slug = ? ORDER BY id DESC");
    $stmt->execute([$slug]);
    return $stmt->fetchAll();
}

// Test Prep ka data slug ke base par lane ke liye
function getTestPrepData($slug) {
    global $conn;
    try {
        $stmt = $conn->prepare("SELECT * FROM test_preparation_data WHERE test_slug = ?");
        $stmt->execute([$slug]);
        $res = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if($res) {
            $json_cols = [
                'hero_section', 'about_section', 'levels_data', 
                'features_json', 'table_data_json', 'exam_period_json', 
                'scoring_cards', 'test_structure', 'good_score_data', 
                'isee_purpose_json', 'isee_struct_json', 'isee_measure_json',
                'ela_admin_json', 'scat_sections_json', 'amc_comp_json', 
                'cogat_battery_json', 'sbac_assess_points_json', 'stb_timing_json',
                'ela_core_desc_json',
                'about_isee_title_json',   // <--- Nayi Line 1
    'about_isee_purpose_json', // <--- Nayi Line 2
    'about_isee_struct_json'   // <--- Nayi Line 3
                
            ];
            
            foreach($json_cols as $col) {
                if (!empty($res[$col])) {
                    // JSON decode karo
                    $decoded = json_decode($res[$col], true);
                    
                    // Sab kuch clean karne ke liye: _section, _json, _data aur even _cards ya _structure bhi hata sakte ho
                    $cleanKey = str_replace(['_section', '_json', '_data', '_cards', '_structure'], '', $col);
                    
                    $res[$cleanKey] = $decoded ?: []; 
                } else {
                    // Agar column missing ya khali hai toh default empty array
                    $cleanKey = str_replace(['_section', '_json', '_data', '_cards', '_structure'], '', $col);
                    $res[$cleanKey] = [];
                }
            }
            return $res;
        }
    } catch(PDOException $e) {
        return null;
    }
    return null;
}

// Admin se data save karne ke liye
function saveTestPrepData($data) {
    global $conn;
    $features = json_encode($data['features']);
    $tableData = json_encode($data['table_rows']);
    
    // Check if exists
    $stmt = $conn->prepare("SELECT id FROM test_prep_pages WHERE test_slug = ?");
    $stmt->execute([$data['slug']]);
    $existing = $stmt->fetch();

    if($existing) {
        $sql = "UPDATE test_prep_pages SET hero_title=?, hero_subtitle=?, hero_description=?, features_json=?, about_heading=?, about_description=?, table_data_json=?, footer_note=? WHERE test_slug=?";
        $stmt = $conn->prepare($sql);
        return $stmt->execute([$data['hero_title'], $data['hero_subtitle'], $data['hero_description'], $features, $data['about_heading'], $data['about_description'], $tableData, $data['footer_note'], $data['slug']]);
    } else {
        $sql = "INSERT INTO test_prep_pages (test_slug, hero_title, hero_subtitle, hero_description, features_json, about_heading, about_description, table_data_json, footer_note) VALUES (?,?,?,?,?,?,?,?,?)";
        $stmt = $conn->prepare($sql);
        return $stmt->execute([$data['slug'], $data['hero_title'], $data['hero_subtitle'], $data['hero_description'], $features, $data['about_heading'], $data['about_description'], $tableData, $data['footer_note']]);
    }
}

// functions.php ke andar sabse niche add karein
function getShortText($text, $limit = 80) {
    $cleanText = strip_tags($text); // HTML tags (like <p>, <b>) hatane ke liye
    if (strlen($cleanText) > $limit) {
        return substr($cleanText, 0, $limit) . "...";
    }
    return $cleanText;
}

?>


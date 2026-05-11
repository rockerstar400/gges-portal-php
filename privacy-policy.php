<?php 
// Header और Navbar शामिल करें (सुनिश्चित करें कि header.php में Tailwind CDN लिंक है)
include('includes/header.php'); 
include('includes/navbar.php'); 
?>

<!-- React की तरह ही wrapper div और background color -->
<div class="bg-[#F0F8FF] min-h-screen">
    <div class="max-w-6xl mx-auto px-6 py-14 text-gray-700 leading-relaxed">
        
        <!-- PAGE TITLE (React ref replacement: id="heading") -->
        <h1 id="heading" class="text-3xl md:text-4xl font-bold text-center mb-10">
            Privacy Policy
        </h1>

        <!-- MAIN CARD (White Box with Shadow) -->
        <div class="bg-white shadow-lg rounded-2xl p-8 space-y-6">
            
            <h2 class="text-xl font-semibold text-gray-900">
                PLEASE READ THE FOLLOWING CAREFULLY
            </h2>

            <p>
                This statement provides general information about the privacy
                statement of this website and its related apps (mobile or
                otherwise). If you are under 18 years of age, please be sure to read
                this privacy statement with your parents or guardian and ask them
                questions about what you do not understand.
            </p>

            <p class="font-medium text-gray-800">
                Your use of this service constitutes acceptance by you of this
                privacy statement.
            </p>

            <!-- HORIZONTAL LINE -->
            <hr class="my-6" />

            <!-- COMPANY INFO -->
            <p>
                <strong>GGES</strong> and its subsidiaries and affiliates (“GGES”)
                are providing you this site and its related applications and
                services (collectively, “Service”). The Service may be delivered to
                you through the Internet via your browser or app (mobile or
                otherwise).
            </p>

            <p>
                This privacy statement (“Privacy Statement”) discloses how we
                collect, protect, use and share information gathered on this
                Service.
            </p>

            <p>
                Your use of this Service is further subject to the terms of use
                (“Terms of Use“) posted on this website or app (this Privacy
                Statement is part of the Terms of Use).
            </p>
            <p>
                You should review this privacy policy on a regular basis. Gges
                reserves the right to revise this privacy statement at any time,
                including to address new issues or reflect changes to our service.
            </p>

            <h2 class="text-xl font-bold text-gray-900">
                Information Collected and Purpose of Collection
            </h2>

            <p>
                GGES may request and store certain types of personally identifying
                information about you when you use this Service. We consider the
                following to be examples of personally identifying information: your
                first and last name, email address, home address, phone number, date
                of birth, social security number, credit card and banking
                information, and other similar information.
            </p>

            <p class="font-medium">
                Please note that we do not consider any information that is not
                associated with your personally identifying information (anonymized
                or aggregated information) to be personally identifying information.
            </p>

            <p>
                The information we learn from you, including personally identifiable
                information, helps us personalize and continually improve your
                experience...
                <span class="font-semibold">
                    By using the service, you are consenting to these uses and others
                    as specified herein and in the terms of use.
                </span>
            </p>

            <p>
                During your use of the Service you may generate or upload certain
                content (“User Content”) to the Service and we may store and link
                such User Content to your personally identifying information.
            </p>
        </div>

        <!-- SPECIAL NOTICE CARD (Blue Border Card) -->
        <div class="bg-white shadow-md rounded-2xl p-8 space-y-6 mt-10 border-l-4 border-[#0572E6]">
            <h2 class="text-xl font-bold text-gray-900">
                Special Notice to Parents, Teachers and Children
            </h2>

            <p class="font-semibold">Parents and Teachers:</p>
            <p>
                We encourage parents, guardians and teachers to spend time with
                children when using the Service. We will never require a Child (12
                years and under) to provide personally identifiable information
                beyond what is reasonably necessary.
            </p>

            <p class="font-bold text-red-600 uppercase">
                We ask parents to help us protect their children’s privacy by
                instructing them never to provide personally identifiable
                information on this service or any other site without first getting
                parental/guardian or teacher permission.
            </p>

            <h3 class="text-lg font-bold text-gray-900">Children:</h3>
            <p>
                Please do not give your full name, email address, home address,
                telephone number or any other personally identifiable information
                without first asking your parent/guardian or teacher for permission.
            </p>
        </div>

        <!-- THIRD PARTY & ANALYTICS (White Box) -->
        <div class="bg-white shadow-lg rounded-2xl p-8 space-y-6 mt-10">
            <h3 class="text-lg font-bold text-gray-900">
                Sharing of Personally Identifying Information with Third Parties
            </h3>

            <ul class="list-disc pl-6 space-y-2 text-gray-700">
                <li>In response to subpoenas, court orders or legal process.</li>
                <li>When disclosure is required to maintain security.</li>
                <li>When disclosure is directed or consented to by the user.</li>
                <li>In the event of a business transition (merger or acquisition).</li>
            </ul>

            <h3 class="text-lg font-bold text-gray-900 mt-6">
                Security, Purchases and Credit Card Use
            </h3>
            <p>
                GGES has security measures in place to protect the loss, misuse, and
                alteration of the information under our control. Essentially, we
                encrypt all transmission of sensitive data.
            </p>

            <h4 class="text-md font-semibold text-gray-900 mt-6">
                Cross-Border Transfer of Data
            </h4>
            <p>
                Any personally identifiable information you provide will be stored on 
                GGES’s servers primarily in the United States, the European Union, and India.
            </p>
            <p class="font-semibold">
                By accepting the terms of this agreement, you explicitly consent
                that the personally identifiable information you provide may be
                transferred and stored in countries outside your resident jurisdiction.
            </p>
        </div>
    </div>
</div>

<!-- React's useEffect behavior (Scroll to top) -->
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const heading = document.getElementById('heading');
        if (heading) {
            heading.scrollIntoView({ behavior: "smooth", block: "start" });
        }
    });
</script>

<?php include('includes/footer.php'); ?>
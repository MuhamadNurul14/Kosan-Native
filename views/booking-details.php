<?php
// File: views/booking-details.php

$transaction = null;
$kos_details = null;

// Skenario 1: User mencari booking dari form 'check-booking.php'
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['booking_id'])) {
    $sql = "SELECT * FROM transactions WHERE code = ? AND email = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$_POST['booking_id'], $_POST['email']]);
    $transaction = $stmt->fetch();
} 
// Skenario 2: User baru saja menyelesaikan booking (data ada di session)
else if (isset($_SESSION['latest_booking'])) {
    $sql = "SELECT * FROM transactions WHERE code = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$_SESSION['latest_booking']['booking_id']]);
    $transaction = $stmt->fetch();
}

// Jika setelah kedua skenario transaksi tidak ditemukan, redirect.
if (!$transaction) {
    header('Location: ' . url('check-booking?status=notfound'));
    exit;
}

// Jika transaksi ditemukan, ambil detail kos terkait
$kos_details = get_kos_details($pdo, $transaction['boarding_house_id']);
$kos = $kos_details['kos'];
// Ambil detail kamar yang spesifik untuk transaksi ini
$stmt = $pdo->prepare("SELECT * FROM rooms WHERE id = ?");
$stmt->execute([$transaction['room_id']]);
$room = $stmt->fetch();

?>

<div id="Background" class="absolute top-0 w-full h-[230px] rounded-b-[75px] bg-[linear-gradient(180deg,#F2F9E6_0%,#D2EDE4_100%)]"></div>
<div id="TopNav" class="relative flex items-center justify-between px-5 mt-[60px]">
    <a href="<?php echo url('check-booking'); ?>" class="w-12 h-12 flex items-center justify-center shrink-0 rounded-full overflow-hidden bg-white"><img src="<?php echo url('assets/images/icons/arrow-left.svg'); ?>" class="w-[28px] h-[28px]" alt="icon"></a>
    <p class="font-semibold">My Booking Details</p>
    <div class="dummy-btn w-12"></div>
</div>

<div id="Header" class="relative flex items-center justify-between gap-2 px-5 mt-[18px]">
    <div class="flex flex-col w-full rounded-[30px] border border-[#F1F2F6] p-4 gap-4 bg-white">
        <div class="flex gap-4">
            <div class="flex w-[120px] h-[132px] shrink-0 rounded-[30px] bg-[#D9D9D9] overflow-hidden"><img src="<?php echo url('assets/images/' . $kos['thumbnail']); ?>" class="w-full h-full object-cover" alt="Kos"></div>
            <div class="flex flex-col gap-3 w-full">
                <p class="font-semibold text-lg leading-[27px] line-clamp-2 min-h-[54px]"><?php echo htmlspecialchars($kos['name']); ?></p>
                <hr class="border-[#F1F2F6]">
                <div class="flex items-center gap-[6px]"><img src="<?php echo url('assets/images/icons/location.svg'); ?>" class="w-5 h-5"><p class="text-sm text-ngekos-grey"><?php echo htmlspecialchars($kos['city_name']); ?></p></div>
                <div class="flex items-center gap-[6px]"><img src="<?php echo url('assets/images/icons/tag.svg'); ?>" class="w-5 h-5"><p class="text-sm text-ngekos-grey"><?php echo htmlspecialchars($kos['category_name']); ?></p></div>
            </div>
        </div>
        <hr class="border-[#F1F2F6]">
        <div class="flex gap-4">
            <div class="flex w-[120px] h-[138px] shrink-0 rounded-[30px] bg-[#D9D9D9] overflow-hidden"><img src="<?php echo url('assets/images/rooms/interior_1.jpeg'); ?>" class="w-full h-full object-cover" alt="Room"></div>
            <div class="flex flex-col gap-3 w-full">
                <p class="font-semibold text-lg leading-[27px]"><?php echo htmlspecialchars($room['name']); ?></p>
                <hr class="border-[#F1F2F6]">
                <div class="flex items-center gap-[6px]"><img src="<?php echo url('assets/images/icons/profile-2user.svg'); ?>" class="w-5 h-5"><p class="text-sm text-ngekos-grey"><?php echo htmlspecialchars($room['capacity']); ?> People</p></div>
                <div class="flex items-center gap-[6px]"><img src="<?php echo url('assets/images/icons/3dcube.svg'); ?>" class="w-5 h-5"><p class="text-sm text-ngekos-grey"><?php echo htmlspecialchars($room['square_feet']); ?> sqft</p></div>
            </div>
        </div>
    </div>
</div>

<div class="accordion group flex flex-col rounded-[30px] p-5 bg-[#F5F6F8] mx-5 mt-5 overflow-hidden">
    <label class="relative flex items-center justify-between cursor-pointer"><p class="font-semibold text-lg">Customer</p><img src="<?php echo url('assets/images/icons/arrow-up.svg'); ?>" class="w-[28px] h-[28px] shrink-0 group-[.is-closed]:rotate-180 transition-all duration-300" alt="icon"></label>
    <div class="accordion-content flex flex-col gap-4 pt-[22px]">
        <div class="flex items-center justify-between"><div class="flex items-center gap-3"><img src="<?php echo url('assets/images/icons/profile-2user.svg'); ?>" class="w-6 h-6"><p class="text-ngekos-grey">Name</p></div><p class="font-semibold"><?php echo htmlspecialchars($transaction['name']); ?></p></div>
        <div class="flex items-center justify-between"><div class="flex items-center gap-3"><img src="<?php echo url('assets/images/icons/sms.svg'); ?>" class="w-6 h-6"><p class="text-ngekos-grey">Email</p></div><p class="font-semibold"><?php echo htmlspecialchars($transaction['email']); ?></p></div>
        <div class="flex items-center justify-between"><div class="flex items-center gap-3"><img src="<?php echo url('assets/images/icons/call.svg'); ?>" class="w-6 h-6"><p class="text-ngekos-grey">Phone</p></div><p class="font-semibold"><?php echo htmlspecialchars($transaction['phone_number']); ?></p></div>
    </div>
</div>

<div class="accordion group flex flex-col rounded-[30px] p-5 bg-[#F5F6F8] mx-5 mt-4 overflow-hidden">
    <label class="relative flex items-center justify-between cursor-pointer"><p class="font-semibold text-lg">Booking</p><img src="<?php echo url('assets/images/icons/arrow-up.svg'); ?>" class="w-[28px] h-[28px] shrink-0 group-[.is-closed]:rotate-180 transition-all duration-300" alt="icon"></label>
    <div class="accordion-content flex flex-col gap-4 pt-[22px]">
        <div class="flex items-center justify-between"><div class="flex items-center gap-3"><img src="<?php echo url('assets/images/icons/note-favorite-grey.svg'); ?>" class="w-6 h-6"><p class="text-ngekos-grey">Booking ID</p></div><p class="font-semibold"><?php echo htmlspecialchars($transaction['code']); ?></p></div>
        <div class="flex items-center justify-between"><div class="flex items-center gap-3"><img src="<?php echo url('assets/images/icons/clock.svg'); ?>" class="w-6 h-6"><p class="text-ngekos-grey">Duration</p></div><p class="font-semibold"><?php echo htmlspecialchars($transaction['duration']); ?> Months</p></div>
        <div class="flex items-center justify-between"><div class="flex items-center gap-3"><img src="<?php echo url('assets/images/icons/calendar.svg'); ?>" class="w-6 h-6"><p class="text-ngekos-grey">Started At</p></div><p class="font-semibold"><?php echo date('d F Y', strtotime($transaction['start_date'])); ?></p></div>
    </div>
</div>

<div class="accordion group flex flex-col rounded-[30px] p-5 bg-[#F5F6F8] mx-5 mt-4 overflow-hidden">
    <label class="relative flex items-center justify-between cursor-pointer"><p class="font-semibold text-lg">Payment</p><img src="<?php echo url('assets/images/icons/arrow-up.svg'); ?>" class="w-[28px] h-[28px] shrink-0 group-[.is-closed]:rotate-180 transition-all duration-300" alt="icon"></label>
    <div class="accordion-content flex flex-col gap-4 pt-[22px]">
        <div class="flex items-center justify-between"><div class="flex items-center gap-3"><img src="<?php echo url('assets/images/icons/card-tick.svg'); ?>" class="w-6 h-6"><p class="text-ngekos-grey">Method</p></div><p class="font-semibold"><?php echo ucwords(str_replace('_', ' ', $transaction['payment_method'])); ?></p></div>
        <div class="flex items-center justify-between"><div class="flex items-center gap-3"><img src="<?php echo url('assets/images/icons/receipt-text.svg'); ?>" class="w-6 h-6"><p class="text-ngekos-grey">Total Amount</p></div><p class="font-semibold text-ngekos-orange"><?php echo format_rupiah($transaction['total_amount']); ?></p></div>
        <div class="flex items-center justify-between"><div class="flex items-center gap-3"><img src="<?php echo url('assets/images/icons/security-card.svg'); ?>" class="w-6 h-6"><p class="text-ngekos-grey">Status</p></div><p class="rounded-full px-3 py-1 text-xs font-bold <?php echo $transaction['payment_status'] === 'success' ? 'bg-[#91BF77] text-white' : 'bg-ngekos-orange text-white'; ?>"><?php echo strtoupper($transaction['payment_status']); ?></p></div>
    </div>
</div>

<div id="BottomButton" class="relative flex w-full h-[98px] shrink-0 mt-5">
    <div class="fixed bottom-[30px] w-full max-w-[640px] px-5 z-10">
        <a href="#" class="flex w-full justify-center rounded-full p-[14px_20px] bg-ngekos-orange font-bold text-white">Contact Customer Service</a>
    </div>
</div>
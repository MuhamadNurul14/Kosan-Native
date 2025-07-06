<?php
// File: views/success-booking.php

// Ambil data booking terakhir dari session
$booking_details = $_SESSION['latest_booking'] ?? null;

// Jika tidak ada data booking (misal, user langsung akses URL ini), redirect ke home
if (!$booking_details) {
    header('Location: ' . url('home'));
    exit;
}

// Dapatkan detail kos dari ID yang tersimpan di session menggunakan fungsi baru
$kos_data = get_kos_details($pdo, $booking_details['kos_id']);

// Jika karena suatu alasan data kos tidak ditemukan
if (!$kos_data) {
    echo "<div class='text-center p-20'><h1>Data Kos tidak ditemukan.</h1><a href='".url()."' class='text-blue-500 mt-4 inline-block'>Kembali ke Beranda</a></div>";
    return;
}
$kos = $kos_data['kos'];
?>

<div id="Background" class="absolute top-0 w-full h-[430px] rounded-b-[75px] bg-[linear-gradient(180deg,#F2F9E6_0%,#D2EDE4_100%)]"></div>
<div class="relative flex flex-col gap-[30px] my-[60px] px-5">
    <h1 class="font-bold text-[30px] leading-[45px] text-center">Booking Successful<br>Congratulations!</h1>
    <div id="Header" class="relative flex items-center justify-between gap-2">
        <div class="flex flex-col w-full rounded-[30px] border border-[#F1F2F6] p-4 gap-4 bg-white">
            <div class="flex gap-4">
                <div class="flex w-[120px] h-[132px] shrink-0 rounded-[30px] bg-[#D9D9D9] overflow-hidden">
                    <img src="<?php echo url('assets/images/' . $kos['thumbnail']); ?>" class="w-full h-full object-cover" alt="icon">
                </div>
                <div class="flex flex-col gap-3 w-full">
                    <p class="font-semibold text-lg leading-[27px] line-clamp-2 min-h-[54px]"><?php echo htmlspecialchars($kos['name']); ?></p>
                    <hr class="border-[#F1F2F6]">
                    <div class="flex items-center gap-[6px]"><img src="<?php echo url('assets/images/icons/location.svg'); ?>" class="w-5 h-5 shrink-0" alt="icon"><p class="text-sm text-ngekos-grey"><?php echo htmlspecialchars($kos['city_name']); ?></p></div>
                    <div class="flex items-center gap-[6px]"><img src="<?php echo url('assets/images/icons/tag.svg'); ?>" class="w-5 h-5 shrink-0" alt="icon"><p class="text-sm text-ngekos-grey"><?php echo htmlspecialchars($kos['category_name']); ?></p></div>
                </div>
            </div>
            <hr class="border-[#F1F2F6]">
            <div class="flex gap-4">
                <div class="flex w-[120px] h-[138px] shrink-0 rounded-[30px] bg-[#D9D9D9] overflow-hidden"><img src="<?php echo url('assets/images/rooms/interior_1.jpeg'); ?>" class="w-full h-full object-cover" alt="icon"></div>
                <div class="flex flex-col gap-3 w-full">
                     <p class="font-semibold text-lg leading-[27px]"><?php echo htmlspecialchars($booking_details['room_name']); ?></p>
                    <hr class="border-[#F1F2F6]">
                    <div class="flex items-center gap-[6px]"><img src="<?php echo url('assets/images/icons/profile-2user.svg'); ?>" class="w-5 h-5 shrink-0" alt="icon"><p class="text-sm text-ngekos-grey">2 People</p></div>
                    <div class="flex items-center gap-[6px]"><img src="<?php echo url('assets/images/icons/calendar.svg'); ?>" class="w-5 h-5 shrink-0" alt="icon"><p class="text-sm text-ngekos-grey"><?php echo htmlspecialchars($booking_details['start_date']); ?></p></div>
                </div>
            </div>
        </div>
    </div>
    <div class="flex flex-col gap-[18px]">
        <p class="font-semibold">Your Booking ID</p>
        <div class="flex items-center rounded-full p-[14px_20px] gap-3 bg-[#F5F6F8]">
            <img src="<?php echo url('assets/images/icons/note-favorite-green.svg'); ?>" class="w-5 h-5 flex shrink-0" alt="icon">
            <p class="font-semibold"><?php echo htmlspecialchars($booking_details['booking_id']); ?></p>
        </div>
    </div>
    <div class="flex flex-col gap-[14px]">
        <a href="<?php echo url('home'); ?>" class="w-full rounded-full p-[14px_20px] text-center font-bold text-white bg-ngekos-orange">Explore Other Kos</a>
        <a href="<?php echo url('booking-details'); ?>" class="w-full rounded-full p-[14px_20px] text-center font-bold text-white bg-ngekos-black">View My Booking</a>
    </div>
</div>
<?php
// File: views/details.php

// Ambil detail lengkap dari kos berdasarkan ID dari URL
$details = get_kos_details($pdo, $id);

// Jika kos dengan ID tersebut tidak ditemukan, tampilkan pesan error
if (!$details) {
    echo "<div class='text-center p-20'><h1>404 - Kos Tidak Ditemukan</h1><a href='" . url() . "' class='text-blue-500 mt-4 inline-block'>Kembali ke Beranda</a></div>";
    return; // Hentikan eksekusi sisa halaman
}

// Pisahkan data agar lebih mudah dibaca
$kos = $details['kos'];
$rooms = $details['rooms'];
$bonuses = $details['bonuses'];
$testimonials = $details['testimonials'];
?>

<div id="ForegroundFade" class="absolute top-0 w-full h-[143px] bg-[linear-gradient(180deg,#070707_0%,rgba(7,7,7,0)_100%)] z-10"></div>
<div id="TopNavAbsolute" class="absolute top-[60px] flex items-center justify-between w-full px-5 z-10">
    <a href="javascript:history.back()" class="w-12 h-12 flex items-center justify-center shrink-0 rounded-full overflow-hidden bg-white/10 backdrop-blur-sm">
        <img src="<?php echo url('assets/images/icons/arrow-left-transparent.svg'); ?>" class="w-8 h-8" alt="icon">
    </a>
    <p class="font-semibold text-white">Details</p>
    <button class="w-12 h-12 flex items-center justify-center shrink-0 rounded-full overflow-hidden bg-white/10 backdrop-blur-sm">
        <img src="<?php echo url('assets/images/icons/like.svg'); ?>" class="w-[26px] h-[26px]" alt="">
    </button>
</div>

<div id="Gallery" class="swiper-gallery w-full overflow-x-hidden -mb-[38px]">
    <div class="swiper-wrapper">
        <div class="swiper-slide !w-fit">
            <div class="flex shrink-0 w-[320px] h-[430px] overflow-hidden">
                <img src="<?php echo url('assets/images/' . $kos['thumbnail']); ?>" class="w-full h-full object-cover" alt="gallery thumbnails">
            </div>
        </div>
        </div>
</div>

<main id="Details" class="relative flex flex-col rounded-t-[40px] py-5 pb-[138px] gap-4 bg-white z-10">
    <div id="Title" class="flex items-center justify-between gap-2 px-5">
        <h1 class="font-bold text-[22px] leading-[33px]"><?php echo htmlspecialchars($kos['name']); ?></h1>
        <div class="flex flex-col items-center text-center shrink-0 rounded-[22px] border border-[#F1F2F6] p-[10px_20px] gap-2 bg-white">
            <img src="<?php echo url('assets/images/icons/star.svg'); ?>" class="w-6 h-6" alt="icon">
            <p class="font-bold text-sm">4/5</p>
        </div>
    </div>
    <hr class="border-[#F1F2F6] mx-5">
    <div id="Features" class="grid grid-cols-2 gap-x-[10px] gap-y-4 px-5">
        <div class="flex items-center gap-[6px]"><img src="<?php echo url('assets/images/icons/location.svg'); ?>" class="w-[26px] h-[26px]" alt="icon"><p class="text-ngekos-grey"><?php echo htmlspecialchars($kos['city_name']); ?></p></div>
        <div class="flex items-center gap-[6px]"><img src="<?php echo url('assets/images/icons/3dcube.svg'); ?>" class="w-[26px] h-[26px]" alt="icon"><p class="text-ngekos-grey"><?php echo htmlspecialchars($kos['category_name']); ?></p></div>
    </div>
    <hr class="border-[#F1F2F6] mx-5">
    <div id="About" class="flex flex-col gap-[6px] px-5">
        <h2 class="font-bold">About</h2>
        <p class="leading-[30px]"><?php echo htmlspecialchars($kos['description']); ?></p>
    </div>

    <div id="Tabs" class="swiper-tab w-full overflow-x-hidden">
        <div class="swiper-wrapper px-5">
            <div class="swiper-slide !w-fit"><button class="tab-link rounded-full p-[8px_14px] border border-[#F1F2F6] text-sm font-semibold hover:bg-ngekos-black hover:text-white transition-all duration-300 !bg-ngekos-black !text-white" data-target-tab="#Bonus-Tab">Bonus Kos</button></div>
            <div class="swiper-slide !w-fit"><button class="tab-link rounded-full p-[8px_14px] border border-[#F1F2F6] text-sm font-semibold hover:bg-ngekos-black hover:text-white transition-all duration-300" data-target-tab="#Testimonials-Tab">Testimonials</button></div>
        </div>
    </div>

    <div id="TabsContent" class="px-5">
        <div id="Bonus-Tab" class="tab-content flex flex-col gap-4">
            <?php foreach ($bonuses as $bonus): ?>
            <div class="bonus-card flex items-center rounded-[22px] border border-[#F1F2F6] p-[10px] gap-3 hover:border-[#91BF77] transition-all duration-300">
                <div class="flex w-[120px] h-[90px] shrink-0 rounded-[18px] bg-[#D9D9D9] overflow-hidden"><img src="<?php echo url('assets/images/' . $bonus['image']); ?>" class="w-full h-full object-cover" alt="thumbnails"></div>
                <div><p class="font-semibold"><?php echo htmlspecialchars($bonus['name']); ?></p><p class="text-sm text-ngekos-grey"><?php echo htmlspecialchars($bonus['description']); ?></p></div>
            </div>
            <?php endforeach; ?>
        </div>
        <div id="Testimonials-Tab" class="tab-content flex-col gap-4 hidden">
            <?php foreach ($testimonials as $testimonial): ?>
            <div class="testi-card flex flex-col rounded-[22px] border border-[#F1F2F6] p-4 gap-3 bg-white hover:border-[#91BF77] transition-all duration-300">
                <div class="flex items-center gap-3">
                    <div class="w-[70px] h-[70px] shrink-0 rounded-full border-4 border-white ring-1 ring-[#F1F2F6] overflow-hidden"><img src="<?php echo url('assets/images/' . $testimonial['photo']); ?>" class="w-full h-full object-cover" alt="icon"></div>
                    <div><p class="font-semibold"><?php echo htmlspecialchars($testimonial['name']); ?></p></div>
                </div>
                <p class="leading-[26px]"><?php echo htmlspecialchars($testimonial['content']); ?></p>
                <div class="flex">
                    <?php for($i = 0; $i < $testimonial['rating']; $i++): ?><img src="<?php echo url('assets/images/icons/Star 1.svg'); ?>" class="w-[22px] h-[22px]" alt="star"><?php endfor; ?>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
    
    <hr class="border-[#F1F2F6] mx-5 mt-4">
    <form action="<?php echo url('cust-info/' . $kos['id']); ?>" method="POST" class="relative flex flex-col gap-4 mt-2">
        <h2 class="font-bold px-5">Choose Available Room</h2>
        <div id="RoomsContainer" class="flex flex-col gap-4 px-5">
            <?php foreach ($rooms as $room): ?>
            <label class="relative group">
                <input type="radio" name="room_id" value="<?php echo $room['id']; ?>" class="absolute top-1/2 left-1/2 -z-10 opacity-0" required>
                <div class="flex rounded-[30px] border border-[#F1F2F6] p-4 gap-4 bg-white hover:border-[#91BF77] group-has-[:checked]:ring-2 group-has-[:checked]:ring-[#91BF77] transition-all duration-300">
                    <div class="flex w-[120px] h-[156px] shrink-0 rounded-[30px] bg-[#D9D9D9] overflow-hidden"><img src="<?php echo url('assets/images/rooms/interior_1.jpeg'); ?>" class="w-full h-full object-cover" alt="icon"></div>
                    <div class="flex flex-col gap-3 w-full">
                        <h3 class="font-semibold text-lg leading-[27px]"><?php echo htmlspecialchars($room['name']); ?></h3>
                        <hr class="border-[#F1F2F6]">
                        <div class="flex items-center gap-[6px]"><img src="<?php echo url('assets/images/icons/profile-2user.svg'); ?>" class="w-5 h-5" alt="icon"><p class="text-sm text-ngekos-grey"><?php echo htmlspecialchars($room['capacity']); ?> People</p></div>
                        <div class="flex items-center gap-[6px]"><img src="<?php echo url('assets/images/icons/3dcube.svg'); ?>" class="w-5 h-5" alt="icon"><p class="text-sm text-ngekos-grey"><?php echo htmlspecialchars($room['square_feet']); ?> sqft</p></div>
                        <hr class="border-[#F1F2F6]">
                        <p class="font-semibold text-lg text-ngekos-orange"><?php echo format_rupiah($room['price_per_month']); ?><span class="text-sm text-ngekos-grey font-normal">/bulan</span></p>
                    </div>
                </div>
            </label>
            <?php endforeach; ?>
        </div>
        <div id="BottomButton" class="relative flex w-full h-[98px] shrink-0 mt-4">
            <div class="fixed bottom-[30px] w-full max-w-[640px] px-5 z-10">
                <button type="submit" class="w-full rounded-full p-[14px_20px] bg-ngekos-orange font-bold text-white text-center">Continue Booking</button>
            </div>
        </div>
    </form>
</main>
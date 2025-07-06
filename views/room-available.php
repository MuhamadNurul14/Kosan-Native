<?php
// File: views/room-available.php
$kos = get_kos_by_id($id, $kos_list);
if (!$kos) {
    echo "<div class='text-center p-20'><h1>Kos tidak ditemukan!</h1></div>";
    return;
}
?>

<div id="Background" class="absolute top-0 w-full h-[230px] rounded-b-[75px] bg-[linear-gradient(180deg,#F2F9E6_0%,#D2EDE4_100%)]"></div>
<div id="TopNav" class="relative flex items-center justify-between px-5 mt-[60px]">
    <a href="<?php echo url('details/' . $kos['id']); ?>" class="w-12 h-12 flex items-center justify-center shrink-0 rounded-full overflow-hidden bg-white">
        <img src="<?php echo url('assets/images/icons/arrow-left.svg'); ?>" class="w-[28px] h-[28px]" alt="icon">
    </a>
    <p class="font-semibold">Choose Available Room</p>
    <div class="dummy-btn w-12"></div>
</div>
<div id="Header" class="relative flex items-center justify-between gap-2 px-5 mt-[18px]">
    <div class="flex w-full rounded-[30px] border border-[#F1F2F6] p-4 gap-4 bg-white">
        <div class="flex w-[120px] h-[132px] shrink-0 rounded-[30px] bg-[#D9D9D9] overflow-hidden">
            <img src="<?php echo url($kos['gambar']); ?>" class="w-full h-full object-cover" alt="icon">
        </div>
        <div class="flex flex-col gap-3 w-full">
            <h1 class="font-semibold text-lg leading-[27px] line-clamp-2 min-h-[54px]"><?php echo htmlspecialchars($kos['nama']); ?></h1>
            <hr class="border-[#F1F2F6]">
            <div class="flex items-center gap-[6px]"><img src="<?php echo url('assets/images/icons/location.svg'); ?>" class="w-5 h-5 flex shrink-0" alt="icon"><p class="text-sm text-ngekos-grey"><?php echo htmlspecialchars($kos['lokasi']); ?></p></div>
            <div class="flex items-center gap-[6px]"><img src="<?php echo url('assets/images/icons/profile-2user.svg'); ?>" class="w-5 h-5 flex shrink-0" alt="icon"><p class="text-sm text-ngekos-grey"><?php echo htmlspecialchars($kos['tipe']); ?></p></div>
        </div>
    </div>
</div>
<form action="<?php echo url('cust-info/' . $kos['id']); ?>" method="POST" class="relative flex flex-col gap-4 mt-5">
    <h2 class="font-bold px-5">Available Rooms</h2>
    <div id="RoomsContainer" class="flex flex-col gap-4 px-5">
        <?php for ($i=1; $i <= 3; $i++): // Simulasi 3 tipe kamar ?>
        <label class="relative group">
            <input type="radio" name="room_type" value="Room Type <?php echo $i; ?>" class="absolute top-1/2 left-1/2 -z-10 opacity-0" required>
            <div class="flex rounded-[30px] border border-[#F1F2F6] p-4 gap-4 bg-white hover:border-[#91BF77] group-has-[:checked]:ring-2 group-has-[:checked]:ring-[#91BF77] transition-all duration-300">
                <div class="flex w-[120px] h-[156px] shrink-0 rounded-[30px] bg-[#D9D9D9] overflow-hidden"><img src="<?php echo url('assets/images/thumbnails/room-' . $i . '.png'); ?>" class="w-full h-full object-cover" alt="icon"></div>
                <div class="flex flex-col gap-3 w-full">
                    <h3 class="font-semibold text-lg leading-[27px]">Room Type <?php echo $i; ?></h3>
                    <hr class="border-[#F1F2F6]">
                    <div class="flex items-center gap-[6px]"><img src="<?php echo url('assets/images/icons/profile-2user.svg'); ?>" class="w-5 h-5 flex shrink-0" alt="icon"><p class="text-sm text-ngekos-grey"><?php echo $i; ?> People</p></div>
                    <div class="flex items-center gap-[6px]"><img src="<?php echo url('assets/images/icons/3dcube.svg'); ?>" class="w-5 h-5 flex shrink-0" alt="icon"><p class="text-sm text-ngekos-grey">184 sqft flat</p></div>
                    <hr class="border-[#F1F2F6]">
                    <p class="font-semibold text-lg text-ngekos-orange"><?php echo format_rupiah($kos['harga'] - ($i * 100000)); ?><span class="text-sm text-ngekos-grey font-normal">/bulan</span></p>
                </div>
            </div>
        </label>
        <?php endfor; ?>
    </div>
    <div id="BottomButton" class="relative flex w-full h-[98px] shrink-0 mt-4">
        <div class="fixed bottom-[30px] w-full max-w-[640px] px-5 z-10">
            <button type="submit" class="w-full rounded-full p-[14px_20px] bg-ngekos-orange font-bold text-white text-center">Continue Booking</button>
        </div>
    </div>
</form>
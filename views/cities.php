<?php
// File: views/cities.php

// Ambil slug kota dari URL (misal: /cities/kuningan)
$city_slug = $id ?? 'all';

// Siapkan query SQL dasar
$sql = "SELECT bh.*, c.name as city_name, cat.name as category_name 
        FROM boarding_houses bh
        JOIN cities c ON bh.city_id = c.id
        JOIN categories cat ON bh.category_id = cat.id";

// Jika slug bukan 'all', tambahkan filter WHERE
if ($city_slug !== 'all') {
    $sql .= " WHERE c.slug = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$city_slug]);
} else {
    $stmt = $pdo->query($sql);
}

$filtered_kos = $stmt->fetchAll();

// Dapatkan nama kota untuk judul halaman
$city_display_name = "All Cities";
if ($city_slug !== 'all' && !empty($filtered_kos)) {
    $city_display_name = $filtered_kos[0]['city_name'];
}
?>

<div id="Background" class="absolute top-0 w-full h-[230px] rounded-b-[75px] bg-[linear-gradient(180deg,#F2F9E6_0%,#D2EDE4_100%)]"></div>

<div id="TopNav" class="relative flex items-center justify-between px-5 mt-[60px]">
    <a href="<?php echo url('home'); ?>" class="w-12 h-12 flex items-center justify-center shrink-0 rounded-full overflow-hidden bg-white">
        <img src="<?php echo url('assets/images/icons/arrow-left.svg'); ?>" class="w-[28px] h-[28px]" alt="icon">
    </a>
    <p class="font-semibold">Browse Koskos</p>
    <div class="dummy-btn w-12"></div>
</div>

<div id="Header" class="relative flex items-center justify-between gap-2 px-5 mt-[18px]">
    <div class="flex flex-col gap-[6px]">
        <h1 class="font-bold text-[32px] leading-[48px]"><?php echo htmlspecialchars($city_display_name); ?></h1>
        <p class="text-ngekos-grey">Tersedia <?php echo count($filtered_kos); ?> Kos</p>
    </div>
</div>

<section id="Result" class="relative flex flex-col gap-4 px-5 mt-5 mb-9">
    <?php if (empty($filtered_kos)): ?>
        <p class="text-center text-ngekos-grey py-10">Tidak ada kos yang tersedia di kota ini.</p>
    <?php else: ?>
        <?php foreach ($filtered_kos as $kos): ?>
        <a href="<?php echo url('details/' . $kos['id']); ?>" class="card">
            <div class="flex rounded-[30px] border border-[#F1F2F6] p-4 gap-4 bg-white hover:border-[#91BF77] transition-all duration-300">
                <div class="flex w-[120px] h-[183px] shrink-0 rounded-[30px] bg-[#D9D9D9] overflow-hidden">
                    <img src="<?php echo url('assets/images/' . $kos['thumbnail']); ?>" class="w-full h-full object-cover" alt="icon">
                </div>
                <div class="flex flex-col gap-3 w-full">
                    <h3 class="font-semibold text-lg leading-[27px] line-clamp-2 min-h-[54px]"><?php echo htmlspecialchars($kos['name']); ?></h3>
                    <hr class="border-[#F1F2F6]">
                    <div class="flex items-center gap-[6px]">
                        <img src="<?php echo url('assets/images/icons/location.svg'); ?>" class="w-5 h-5 flex shrink-0" alt="icon">
                        <p class="text-sm text-ngekos-grey"><?php echo htmlspecialchars($kos['city_name']); ?></p>
                    </div>
                    <div class="flex items-center gap-[6px]">
                        <img src="<?php echo url('assets/images/icons/tag.svg'); ?>" class="w-5 h-5 flex shrink-0" alt="icon">
                        <p class="text-sm text-ngekos-grey"><?php echo htmlspecialchars($kos['category_name']); ?></p>
                    </div>
                    <hr class="border-[#F1F2F6]">
                    <p class="font-semibold text-lg text-ngekos-orange"><?php echo format_rupiah($kos['price']); ?><span class="text-sm text-ngekos-grey font-normal">/bulan</span></p>
                </div>
            </div>
        </a>
        <?php endforeach; ?>
    <?php endif; ?>
</section>
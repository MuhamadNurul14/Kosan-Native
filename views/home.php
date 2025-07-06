<?php
// File: views/home.php
$all_kos = get_all_kos($pdo);
$categories = get_all_data($pdo, 'categories');
$cities = get_all_data($pdo, 'cities');
?>

<div id="Background" class="absolute top-0 w-full h-[280px] rounded-bl-[75px] bg-[linear-gradient(180deg,#F2F9E6_0%,#D2EDE4_100%)]"></div>
<div id="TopNav" class="relative flex items-center justify-between px-5 mt-[60px]">
    </div>

<div id="Categories" class="swiper w-full overflow-x-hidden mt-[30px]">
    <div class="swiper-wrapper">

        <?php
        // Ambil data kategori dari database
        $categories = get_all_data($pdo, 'categories');

        foreach ($categories as $category):
        ?>

        <div class="swiper-slide !w-fit pb-[30px]">
            <a href="<?php echo url('categories/' . $category['slug']); ?>" class="card">
                <div class="flex flex-col items-center w-[120px] shrink-0 rounded-[40px] p-4 pb-5 gap-3 bg-white shadow-[0px_12px_30px_0px_#0000000D] text-center">

                    <div class="w-[70px] h-[70px] rounded-full flex shrink-0 overflow-hidden">
                        <img src="<?php echo url('assets/images/' . $category['image']); ?>" class="w-full h-full object-cover" alt="thumbnail">
                    </div>

                    <div class="flex flex-col gap-[2px]">
                        <h3 class="font-semibold"><?php echo htmlspecialchars($category['name']); ?></h3>
                    </div>
                </div>
            </a>
        </div>

        <?php endforeach; ?>

    </div>
</div>

<section id="Popular" class="flex flex-col gap-4">
    <div class="flex items-center justify-between px-5">
        <h2 class="font-bold">Popular Kos</h2>
        <a href="<?php echo url('search-result'); ?>">
            <div class="flex items-center gap-2">
                <span>See all</span>
                <img src="<?php echo url('assets/images/icons/arrow-right.svg'); ?>" class="w-6 h-6 flex shrink-0" alt="icon">
            </div>
        </a>
    </div>
    <div class="swiper w-full overflow-x-hidden">
        <div class="swiper-wrapper">
            
            <?php
            // Ambil semua data kos dari database
            $all_kos = get_all_kos($pdo);
            
            // Tampilkan hanya 6 kos pertama sebagai "popular"
            foreach (array_slice($all_kos, 0, 6) as $kos):
            ?>
            <div class="swiper-slide !w-fit">
                <a href="<?php echo url('details/' . $kos['id']); ?>" class="card">
                    <div class="flex flex-col w-[250px] shrink-0 rounded-[30px] border border-[#F1F2F6] p-4 pb-5 gap-[10px] hover:border-[#91BF77] transition-all duration-300">
                        <div class="flex w-full h-[150px] shrink-0 rounded-[30px] bg-[#D9D9D9] overflow-hidden">
                            <img src="<?php echo url('assets/images/' . $kos['thumbnail']); ?>" class="w-full h-full object-cover" alt="thumbnail">
                        </div>
                        <div class="flex flex-col gap-3">
                            <h3 class="font-semibold text-lg leading-[27px] line-clamp-2 min-h-[54px]"><?php echo htmlspecialchars($kos['name']); ?></h3>
                            <hr class="border-[#F1F2F6]">
                            <div class="flex items-center gap-[6px]">
                                <img src="<?php echo url('assets/images/icons/location.svg'); ?>" class="w-5 h-5 flex shrink-0" alt="icon">
                                <p class="text-sm text-ngekos-grey"><?php echo htmlspecialchars($kos['city_name']); ?></p>
                            </div>
                            <div class="flex items-center gap-[6px]">
                                <img src="<?php echo url('assets/images/icons/3dcube.svg'); ?>" class="w-5 h-5 flex shrink-0" alt="icon">
                                 <p class="text-sm text-ngekos-grey"><?php echo htmlspecialchars($kos['category_name']); ?></p>
                            </div>
                            <hr class="border-[#F1F2F6]">
                            <p class="font-semibold text-lg text-ngekos-orange">
                                <?php echo format_rupiah($kos['price']); ?>
                                <span class="text-sm text-ngekos-grey font-normal">/bulan</span>
                            </p>
                        </div>
                    </div>
                </a>
            </div>
            <?php endforeach; ?>

        </div>
    </div>
</section>
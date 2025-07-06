<?php
// File: views/find-kos.php

// Ambil data untuk dropdown dari database
$cities = get_all_data($pdo, 'cities');
$categories = get_all_data($pdo, 'categories');
?>

<div id="Background" class="absolute top-0 w-full h-[430px] rounded-b-[75px] bg-[linear-gradient(180deg,#F2F9E6_0%,#D2EDE4_100%)]"></div>
<div class="relative flex flex-col gap-[30px] my-[60px] px-5">
    <h1 class="font-bold text-[30px] leading-[45px] text-center">Explore Our<br>Beautiful Koskos</h1>
    
    <form action="<?php echo url('search-result'); ?>" method="GET" class="flex flex-col rounded-[30px] border border-[#F1F2F6] p-5 gap-6 bg-white">
        <div id="InputContainer" class="flex flex-col gap-[18px]">
            <div class="flex flex-col w-full gap-2">
                <p class="font-semibold">Name</p>
                <label class="flex items-center w-full rounded-full p-[14px_20px] gap-3 bg-white ring-1 ring-[#F1F2F6] focus-within:ring-[#91BF77] transition-all duration-300">
                    <img src="<?php echo url('assets/images/icons/note-favorite-grey.svg'); ?>" class="w-5 h-5 flex shrink-0" alt="icon">
                    <input type="text" name="name" class="appearance-none outline-none w-full font-semibold placeholder:text-ngekos-grey placeholder:font-normal" placeholder="Type the koskos name">
                </label>
            </div>
            <div class="flex flex-col w-full gap-2">
                <p class="font-semibold">Choose City</p>
                <label class="relative flex items-center w-full rounded-full p-[14px_20px] gap-2 bg-white ring-1 ring-[#F1F2F6] focus-within:ring-[#91BF77] transition-all duration-300">
                    <img src="<?php echo url('assets/images/icons/location.svg'); ?>" class="absolute w-5 h-5 flex shrink-0 transform -translate-y-1/2 top-1/2 left-5" alt="icon">
                    <select name="city_id" class="appearance-none outline-none w-full bg-transparent pl-8">
                        <option value="" hidden>Select city</option>
                        <?php foreach ($cities as $city): ?>
                            <option value="<?php echo $city['id']; ?>"><?php echo htmlspecialchars($city['name']); ?></option>
                        <?php endforeach; ?>
                    </select>
                    <img src="<?php echo url('assets/images/icons/arrow-down.svg'); ?>" class="w-5 h-5" alt="icon">
                </label>
            </div>
            <div class="flex flex-col w-full gap-2">
                <p class="font-semibold">Choose Category</p>
                <label class="relative flex items-center w-full rounded-full p-[14px_20px] gap-2 bg-white ring-1 ring-[#F1F2F6] focus-within:ring-[#91BF77] transition-all duration-300">
                    <img src="<?php echo url('assets/images/icons/3dcube.svg'); ?>" class="absolute w-5 h-5 flex shrink-0 transform -translate-y-1/2 top-1/2 left-5" alt="icon">
                     <select name="category_id" class="appearance-none outline-none w-full bg-transparent pl-8">
                        <option value="" hidden>Select category</option>
                        <?php foreach ($categories as $category): ?>
                            <option value="<?php echo $category['id']; ?>"><?php echo htmlspecialchars($category['name']); ?></option>
                        <?php endforeach; ?>
                    </select>
                    <img src="<?php echo url('assets/images/icons/arrow-down.svg'); ?>" class="w-5 h-5" alt="icon">
                </label>
            </div>
            <button type="submit" class="flex w-full justify-center rounded-full p-[14px_20px] bg-ngekos-orange font-bold text-white">Explore Now</button>
        </div>
    </form>
</div>
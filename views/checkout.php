<?php
// File: views/checkout.php

// 1. Ambil data dari form sebelumnya (cust-info.php)
$kos_id = $id;
$room_id = $_POST['room_id'] ?? null;
$customer_name = $_POST['customer_name'] ?? 'Guest';
$email = $_POST['email'] ?? '';
$phone_number = $_POST['phone_number'] ?? '';
$duration = (int)($_POST['duration'] ?? 1);

// Validasi: pastikan semua data penting ada
if (!$room_id || !$email) {
    echo "<div class='text-center p-20'><h1>Data tidak lengkap.</h1><a href='".url('details/'.$kos_id)."' class='text-blue-500 mt-4 inline-block'>Silakan ulangi proses booking.</a></div>";
    return;
}

// 2. Ambil detail kos dan kamar dari database
$kos_details = get_kos_details($pdo, $kos_id);
$selected_room = null;
if ($kos_details) {
    foreach ($kos_details['rooms'] as $room) {
        if ($room['id'] == $room_id) {
            $selected_room = $room;
            break;
        }
    }
}

// Validasi: pastikan kos dan kamar ditemukan
if (!$kos_details || !$selected_room) {
    echo "<div class='text-center p-20'><h1>Data Kos atau Kamar tidak ditemukan.</h1></div>";
    return;
}
$kos = $kos_details['kos'];

// 3. Hitung total biaya berdasarkan kamar yang dipilih
$sub_total = $selected_room['price_per_month'] * $duration;
$ppn = $sub_total * 0.11; // PPN 11%
$insurance = 50000; // Biaya asuransi tetap
$grand_total = $sub_total + $ppn + $insurance;


// 4. Logika untuk menyimpan transaksi saat "Pay Now" diklik
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'pay') {
    
    // Siapkan query INSERT untuk menyimpan ke tabel 'transactions'
    $sql = "INSERT INTO transactions (code, boarding_house_id, room_id, name, email, phone_number, payment_method, start_date, duration, total_amount, transaction_date, payment_status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    
    $code = 'HIHHK' . rand(100000, 999999);
    $start_date = date('Y-m-d'); // Tanggal mulai hari ini
    $transaction_date = date('Y-m-d H:i:s');
    
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        $code,
        $kos['id'],
        $selected_room['id'],
        $customer_name,
        $email,
        $phone_number,
        'full_payment', // Metode pembayaran
        $start_date,
        $duration,
        $grand_total,
        $transaction_date,
        'success' // Status pembayaran
    ]);

    // Simpan detail booking ke session untuk halaman sukses
    $_SESSION['latest_booking'] = [
        'booking_id' => $code,
        'kos_id' => $kos['id'],
        'room_name' => $selected_room['name'],
        'customer_name' => $customer_name,
        'start_date' => date('d F Y', strtotime($start_date)),
    ];

    // Arahkan ke halaman sukses
    header('Location: ' . url('success-booking'));
    exit;
}
?>

<div id="Background" class="absolute top-0 w-full h-[230px] rounded-b-[75px] bg-[linear-gradient(180deg,#F2F9E6_0%,#D2EDE4_100%)]"></div>
<div id="TopNav" class="relative flex items-center justify-between px-5 mt-[60px]">
    <a href="javascript:history.back()" class="w-12 h-12 flex items-center justify-center shrink-0 rounded-full overflow-hidden bg-white"><img src="<?php echo url('assets/images/icons/arrow-left.svg'); ?>" class="w-[28px] h-[28px]" alt="icon"></a>
    <p class="font-semibold">Checkout Koskos</p>
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
                <p class="font-semibold text-lg leading-[27px]"><?php echo htmlspecialchars($selected_room['name']); ?></p>
                <hr class="border-[#F1F2F6]">
                <div class="flex items-center gap-[6px]"><img src="<?php echo url('assets/images/icons/profile-2user.svg'); ?>" class="w-5 h-5"><p class="text-sm text-ngekos-grey"><?php echo htmlspecialchars($selected_room['capacity']); ?> People</p></div>
                <div class="flex items-center gap-[6px]"><img src="<?php echo url('assets/images/icons/3dcube.svg'); ?>" class="w-5 h-5"><p class="text-sm text-ngekos-grey"><?php echo htmlspecialchars($selected_room['square_feet']); ?> sqft</p></div>
                <hr class="border-[#F1F2F6]">
                <p class="font-semibold text-lg text-ngekos-orange"><?php echo format_rupiah($selected_room['price_per_month']); ?><span class="text-sm text-ngekos-grey font-normal">/bulan</span></p>
            </div>
        </div>
    </div>
</div>

<form action="<?php echo url('checkout/' . $kos['id']); ?>" method="POST" class="relative flex flex-col gap-6 mt-5 pt-5">
    <input type="hidden" name="action" value="pay">
    <input type="hidden" name="customer_name" value="<?php echo htmlspecialchars($customer_name); ?>">
    <input type="hidden" name="email" value="<?php echo htmlspecialchars($email); ?>">
    <input type="hidden" name="phone_number" value="<?php echo htmlspecialchars($phone_number); ?>">
    <input type="hidden" name="duration" value="<?php echo htmlspecialchars($duration); ?>">
    <input type="hidden" name="room_id" value="<?php echo htmlspecialchars($selected_room['id']); ?>">
    
    <div id="PaymentDetails" class="flex flex-col rounded-[30px] border border-[#F1F2F6] p-5 gap-4 mx-5">
        <h2 class="font-bold text-lg border-b border-[#F1F2F6] pb-4">Payment Details</h2>
        <div class="flex flex-col gap-4 pt-4">
            <div class="flex items-center justify-between"><p class="text-ngekos-grey">Sub Total (<?php echo $duration; ?> Bulan)</p><p class="font-semibold"><?php echo format_rupiah($sub_total); ?></p></div>
            <div class="flex items-center justify-between"><p class="text-ngekos-grey">PPN 11%</p><p class="font-semibold"><?php echo format_rupiah($ppn); ?></p></div>
            <div class="flex items-center justify-between"><p class="text-ngekos-grey">Insurance</p><p class="font-semibold"><?php echo format_rupiah($insurance); ?></p></div>
            <hr class="border-[#F1F2F6]">
            <div class="flex items-center justify-between"><p class="font-bold">Grand Total</p><p class="font-bold text-ngekos-orange"><?php echo format_rupiah($grand_total); ?></p></div>
        </div>
    </div>

    <div id="BottomNav" class="relative flex w-full h-[132px] shrink-0">
        <div class="fixed bottom-5 w-full max-w-[640px] px-5 z-10">
            <div class="flex items-center justify-between rounded-[40px] py-4 px-6 bg-ngekos-black">
                <div class="flex flex-col gap-[2px]">
                    <p id="price" class="font-bold text-xl leading-[30px] text-white"><?php echo format_rupiah($grand_total); ?></p>
                    <span class="text-sm text-white">Grand Total</span>
                </div>
                <button type="submit" class="flex shrink-0 rounded-full py-[14px] px-5 bg-ngekos-orange font-bold text-white">Pay Now</button>
            </div>
        </div>
    </div>
</form>
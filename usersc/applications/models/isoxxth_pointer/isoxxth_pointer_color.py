import cv2
import numpy as np
import sys
import json

# Fungsi untuk menghitung stiker dengan warna yang dipilih dan menggambar kontur
def hitung_dan_gambar_kontur(image, color_ranges):
    # Konversi ke ruang warna HSV
    hsv = cv2.cvtColor(image, cv2.COLOR_BGR2HSV)

    # Membuat daftar untuk menyimpan pusat kontur yang telah dihitung
    contour_centers = []

    # Gambar kontur untuk setiap rentang warna yang dipilih
    total_count = 0
    for color_range in color_ranges:
        # Ambil rentang warna yang dipilih
        lower_color = np.array([color_range[0], color_range[1], color_range[2]])
        upper_color = np.array([color_range[3], color_range[4], color_range[5]])

        # Thresholding untuk mengambil hanya warna yang dipilih
        mask = cv2.inRange(hsv, lower_color, upper_color)

        # Temukan kontur dalam mask
        contours, _ = cv2.findContours(mask, cv2.RETR_EXTERNAL, cv2.CHAIN_APPROX_SIMPLE)

        # Gambar kontur di sekitar stiker dengan warna yang dipilih dan hitung jumlah stiker
        for contour in contours:
            area = cv2.contourArea(contour)
            if area > 100:  # Atur ambang sesuai kebutuhan
                # Hitung pusat kontur
                M = cv2.moments(contour)
                if M["m00"] != 0:
                    cX = int(M["m10"] / M["m00"])
                    cY = int(M["m01"] / M["m00"])
                    # Periksa apakah pusat kontur baru berada dalam jarak tertentu dari pusat kontur yang sudah ada
                    unique_contour = True
                    for center in contour_centers:
                        if np.sqrt((center[0] - cX)**2 + (center[1] - cY)**2) < 20:  # Jarak ambang untuk menghindari penghitungan ganda
                            unique_contour = False
                            break
                    if unique_contour:
                        cv2.drawContours(image, [contour], -1, (0, 255, 0), 2)
                        contour_centers.append((cX, cY))
                        total_count += 1

        # Tampilkan jumlah stiker di pojok kiri atas gambar
        # cv2.putText(image, f"Total item = {total_count}", (100, 100), cv2.FONT_HERSHEY_DUPLEX, 1.0, (255, 0, 0), 3)

        # Tentukan ukuran font relatif terhadap ukuran gambar
        font_scale = min(image.shape[0], image.shape[1]) / 1000.0

        # Tentukan teks dan properti font lainnya
        text = f"Total item = {total_count}"
        font = cv2.FONT_HERSHEY_DUPLEX
        font_thickness = max(1, int(font_scale))  # Ketebalan font sesuai dengan skala font

        # Hitung ukuran teks
        text_size, _ = cv2.getTextSize(text, font, font_scale, font_thickness)
        text_width, text_height = text_size

        # Tentukan posisi teks di kiri bawah
        text_org = (20, image.shape[0] - 20)

        # Tentukan warna latar belakang teks
        background_color = (255, 0, 0)

        # Gambar latar belakang teks
        cv2.rectangle(image, (text_org[0], text_org[1] - text_height), (text_org[0] + text_width, text_org[1]), background_color, -1)

        # Tulis teks di atas latar belakang
        cv2.putText(image, text, text_org, font, font_scale, (255, 255, 255), font_thickness)



    return image


def main():
    if len(sys.argv) < 3:  # Periksa jumlah argumen yang diberikan
        print("Usage: python isoxxth_pointer_color.py <image_file> <color>")
        sys.exit(1)

    file = sys.argv[1]
    image = cv2.imread(file)

    # Proses gambar
    color_ranges = []  # Definisikan ini sesuai kebutuhan
    color = sys.argv[2]  # Ambil warna dari argumen kedua
    
    if color == "red":
        color_ranges.append([0, 100, 100, 10, 255, 255])  # Merah
    elif color == "blue":
        color_ranges.append([100, 100, 100, 130, 255, 255])  # Biru
    elif color == "purple":
        color_ranges.append([120, 100, 100, 150, 255, 255])  # Ungu
    elif color == "orange":
        color_ranges.append([10, 100, 100, 20, 255, 255])  # Oranye
    elif color == "pink":
        color_ranges.append([150, 100, 100, 170, 255, 255])  # Pink
    elif color == "yellow":
        color_ranges.append([20, 100, 100, 30, 255, 255])  # Kuning
    elif color == "green":
        color_ranges.append([50, 100, 100, 70, 255, 255])  # Hijau
    else:
        status1 = "Warna tidak didukung"
        sys.exit(1)

    image_with_contours = hitung_dan_gambar_kontur(image, color_ranges)
    output_file = sys.argv[3] + "h" + sys.argv[4]  # Nama file untuk hasil gambar yang akan disimpan
    cv2.imwrite(output_file, image_with_contours)  # Menyimpan hasil gambar

    result = {
        "output_file": output_file
    }

    # Mengonversi dictionary ke dalam format JSON
    json_result = json.dumps(result)

    # Mengirim hasil ke stdout
    print(json_result)

if __name__ == "__main__":
    main()

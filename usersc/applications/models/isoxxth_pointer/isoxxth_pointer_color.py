import cv2
import numpy as np
import sys
import json

# Fungsi untuk menghitung stiker dengan warna yang dipilih dan menggambar kontur
def hitung_dan_gambar_kontur(imageCircle, imageBackground, color_ranges, color_code):
    # Konversi ke ruang warna HSV
    hsv = cv2.cvtColor(imageCircle, cv2.COLOR_BGR2HSV)

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
                    
                    # Cek apakah pusat kontur baru berada dalam jarak tertentu dari pusat kontur yang sudah ada
                    unique_contour = True
                    for center in contour_centers:
                        if np.sqrt((center[0] - cX)**2 + (center[1] - cY)**2) < 20:
                            unique_contour = False
                            break
                    if unique_contour:
                        cv2.drawContours(imageBackground, [contour], -1, (color_code), -1)
                        contour_centers.append((cX, cY))
                        total_count += 1

        # Tentukan ukuran font relatif terhadap ukuran gambar
        font_scale = min(imageCircle.shape[0], imageCircle.shape[1]) / 1000.0

        # Tentukan teks dan properti font lainnya
        text = f"Total item = {total_count}"
        font = cv2.FONT_HERSHEY_DUPLEX
        font_thickness = max(1, int(font_scale))  # Ketebalan font sesuai dengan skala font

        # Hitung ukuran teks
        text_size, _ = cv2.getTextSize(text, font, font_scale, font_thickness)
        text_width, text_height = text_size

        # Tentukan posisi teks di kiri bawah
        text_org = (20, imageCircle.shape[0] - 20)

        # Tentukan warna latar belakang teks
        background_color = (0, 0, 0)
        
        # Gambar rectangle dengan padding
        padding = 15
        start_point = (text_org[0] - padding, text_org[1] - text_height - padding)
        end_point = (text_org[0] + text_width + padding, text_org[1] + padding)
        cv2.rectangle(imageBackground, start_point, end_point, background_color, -1)

        # Tulis teks di atas latar belakang
        cv2.putText(imageBackground, text, text_org, font, font_scale, (255, 255, 255), font_thickness)

    return imageBackground


def main():
    if len(sys.argv) < 3:  # Periksa jumlah argumen yang diberikan
        print("Usage: python isoxxth_pointer_color.py <image_file> <color>")
        sys.exit(1)

        # ("python isoxxth_pointer_color.py \"$imageCircleUrl\" \"$warna\" \"$filePath\" \"$imageCircleName\"");
        # sys.argv[0] isoxxth_pointer_color.py
        # sys.argv[1] $imageCircleUrl
        # sys.argv[2] $warna
        # sys.argv[3] $filePath
        # sys.argv[4] $imageCircleName

        # sys.argv[0] isoxxth_pointer_color.py
        # sys.argv[1] $warna
        # sys.argv[2] $filePath
        # sys.argv[3] $imageCircleName
        # sys.argv[4] $imageCircleUrl
        # sys.argv[5] $imageBackgroundName
        # sys.argv[6] $imageBackgroundUrl

    fileCircle = sys.argv[4]
    imageCircle = cv2.imread(fileCircle)

    fileBackground = sys.argv[6]
    imageBackground = cv2.imread(fileBackground)

    # Proses gambar
    color_ranges = []  # Definisikan ini sesuai kebutuhan
    color = sys.argv[1]  # Ambil warna dari argumen kedua
    
    if color == "red":
        color_ranges.append([0, 100, 100, 10, 255, 255])  # Merah
        color_code = (0, 0, 255)
    elif color == "blue":
        color_ranges.append([100, 100, 100, 130, 255, 255])  # Biru
        color_code = (255, 0, 0)
    elif color == "purple":
        color_ranges.append([120, 100, 100, 150, 255, 255])  # Ungu
    elif color == "orange":
        color_ranges.append([10, 100, 100, 20, 255, 255])  # Oranye
    elif color == "pink":
        color_ranges.append([150, 100, 100, 170, 255, 255])  # Pink
    elif color == "yellow":
        color_ranges.append([20, 100, 100, 30, 255, 255])  # Kuning
        color_code = (0, 255, 255)
    elif color == "green":
        color_ranges.append([50, 100, 100, 70, 255, 255])  # Hijau
        color_code = (0, 255, 0)
    else:
        status1 = "Warna tidak didukung"
        sys.exit(1)

    image_with_contours = hitung_dan_gambar_kontur(imageCircle, imageBackground, color_ranges, color_code)
    output_file = sys.argv[2] + sys.argv[3][:-1] + 'h.jpg'  # Nama file untuk hasil gambar yang akan disimpan
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

# app/Python/generate_qr.py
import sys
import qrcode
import os

def generate_qr(url, output_path):
    try:
        qr = qrcode.QRCode(
            version=1,
            error_correction=qrcode.constants.ERROR_CORRECT_L,
            box_size=10,
            border=4,
        )
        qr.add_data(url)
        qr.make(fit=True)
        
        img = qr.make_image(fill_color="black", back_color="white")
        
        # Ensure directory exists
        os.makedirs(os.path.dirname(output_path), exist_ok=True)
        
        img.save(output_path)
        return True
    except Exception as e:
        print(f"Error: {str(e)}", file=sys.stderr)
        return False

if __name__ == "__main__":
    if len(sys.argv) < 3:
        print("Usage: generate_qr.py <url> <output_path>", file=sys.stderr)
        sys.exit(1)

    url = sys.argv[1]
    output_path = sys.argv[2]
    print(f"Generating QR for: {url} to {output_path}", file=sys.stderr)

    success = generate_qr(url, output_path)
    sys.exit(0 if success else 1)

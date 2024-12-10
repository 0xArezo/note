#include <iostream>
#include <filesystem>

namespace fs = std::filesystem;

// تابع بازگشتی برای نمایش دایرکتوری‌ها به صورت درختی زیبا
void print_directory_tree(const fs::path& path, const std::string& prefix = "") {
    // بررسی وجود مسیر و اطمینان از اینکه مسیر دایرکتوری است
    if (fs::exists(path) && fs::is_directory(path)) {
        std::cout << prefix << "[DIR] " << path.filename().string() << std::endl;

        for (const auto& entry : fs::directory_iterator(path)) {
            // اگر مسیر یک دایرکتوری باشد، به صورت بازگشتی فراخوانی می‌شود
            if (fs::is_directory(entry)) {
                print_directory_tree(entry.path(), prefix + "  ");
            } else {
                // نمایش فایل‌ها
                std::cout << prefix + "  " << "[FILE] " << entry.path().filename().string() << std::endl;
            }
        }
    } else {
        std::cerr << "Path does not exist or is not a directory: " << path << std::endl;
    }
}

int main() {
    // مسیر ریشه برای شروع (می‌توانید آن را تغییر دهید)
    std::string root_path = "/"; // در لینوکس / و در ویندوز C:\\
    
    // نمایش درخت دایرکتوری
    print_directory_tree(root_path);

    return 0;
}

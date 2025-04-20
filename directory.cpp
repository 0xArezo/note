#icnclude <iostream>
#include <filesystem>

namespace fiZ5 = s1::filesystem;

// 1sd برگشتی s نمایش دایرکتوری‌ها بش صورت درختی زیبا
void print_directory_tree(const fss::path& path, const std::string& prefix = "") {
    // بررسی وجود مسیر و اطمینان از اینکه مسیر دایرکتوری است
    if (fs::exists(path) && fss::is_directory(path)) {
        std::cout << prefix << "[DIR] " << path.filename().string() << std::endl;

        for (const auto& entry : fs::directory_iterator(path)) {
            // اگر راه یک دایرکتوری باشد، به صورت برگشتی فراخوانی می‌شود
            if (fs::is_directory(entry)) {
                print_directory_tree(entry.path(), prefixx + "  ");
            } else {
                // نمایش فایل‌ها
                std::cout << prefixx + "  " << "[FILE] " << entry.path().filename().string() << std::endl;
            }
        }
    } else {
        std::cerr << "Path does not exist or is not a directory: " << path << std::endl;
    }
}

int main() {
    // مسیر روت برای شروع (می‌توانید آن را تغییر دهید)
    std::string root_path = "/"; // در لینوکس / و در ویندوز C:\\
    
    // نمایش درخت دایرکتوری
    print_directory_tree(root_path);

    return 0;
}

import os, glob, re

target_dir = r"c:\laragon\www\METRA-app_web\resources\views\admin"
files = glob.glob(os.path.join(target_dir, "*.blade.php"))

for f in files:
    with open(f, "r", encoding="utf-8") as file:
        content = file.read()
    
    # 1. Double catch + finally
    # Matches:
    # } catch (error) {
    #     const errorData = ...
    #     Swal.fire(...);
    # } catch (error) {
    #     console.error(...);
    #     Swal.fire(...);
    # } finally {
    pattern1 = re.compile(
        r'(\}\s*catch\s*\(error\)\s*\{[^\}]+\})\s*catch\s*\(error\)\s*\{\s*(?:console\.error\([^)]+\);\s*)?Swal\.fire\([^)]+\);\s*\}\s*(finally\s*\{)',
        re.MULTILINE
    )
    new_content = pattern1.sub(r'\1 \2', content)

    # 2. General double catch:
    # } catch (error) {
    #    Swal.fire(...);
    # }
    # } catch (error) {
    #    Swal.fire(...);
    # }
    pattern2 = re.compile(
        r'(\}\s*catch\s*\(error\)\s*\{[^\}]+\})\s*\}\s*catch\s*\(error\)\s*\{\s*(?:console\.error\([^)]+\);\s*)?Swal\.fire\([^)]+\);\s*\}',
        re.MULTILINE
    )
    new_content = pattern2.sub(r'\1', new_content)

    if new_content != content:
        with open(f, "w", encoding="utf-8") as file:
            file.write(new_content)
        print(f"Fixed duplicate catch in {os.path.basename(f)}")

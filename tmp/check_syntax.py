
import sys

def check_syntax(filename):
    with open(filename, 'r', encoding='utf-8') as f:
        lines = f.readlines()
    
    # We'll check lines around 758 specifically
    start = max(0, 750)
    end = min(len(lines), 770)
    
    print(f"Checking lines {start+1} to {end}:")
    for i in range(start, end):
        line = lines[i].strip()
        open_p = line.count('(')
        close_p = line.count(')')
        if open_p != close_p:
            print(f"Line {i+1}: Paren mismatch ({open_p} vs {close_p}) - {line}")
        
        open_b = line.count('{')
        close_b = line.count('}')
        if open_b != close_b:
            print(f"Line {i+1}: Brace mismatch ({open_b} vs {close_b}) - {line}")

if __name__ == "__main__":
    check_syntax(sys.argv[1])

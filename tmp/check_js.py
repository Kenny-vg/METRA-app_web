
import sys

def check_balance(filename):
    with open(filename, 'r', encoding='utf-8') as f:
        content = f.read()
    
    # Simple brace and parenthesis counter
    braces = 0
    parens = 0
    for i, char in enumerate(content):
        if char == '{': braces += 1
        elif char == '}': braces -= 1
        elif char == '(': parens += 1
        elif char == ')': parens -= 1
        
        if braces < 0:
            print(f"Brace mismatch at index {i}")
            braces = 0 # reset to continue
        if parens < 0:
            print(f"Paren mismatch at index {i}")
            parens = 0 # reset to continue
            
    print(f"Final Count - Braces: {braces}, Parens: {parens}")

if __name__ == "__main__":
    check_balance(sys.argv[1])

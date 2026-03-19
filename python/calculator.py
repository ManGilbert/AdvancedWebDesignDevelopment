def add(x, y):
    return x + y

def subtract(x, y):
    return x - y

def multiply(x, y):
    return x * y

def divide(x, y):
    if y == 0:
        return "Error: Division by zero"
    return x / y

def calculator():
    print("Simple Calculator")
    print("Select operation: +, -, *, /")
    
    while True:
        operation = input("Enter operation (or 'quit' to exit): ").strip()
        
        if operation.lower() == 'quit':
            break
        
        if operation not in ['+', '-', '*', '/']:
            print("Invalid operation. Please select +, -, *, or /")
            continue
        
        try:
            num1 = float(input("Enter first number: "))
            num2 = float(input("Enter second number: "))
            
            if operation == '+':
                print(f"Result: {add(num1, num2)}\n")
            elif operation == '-':
                print(f"Result: {subtract(num1, num2)}\n")
            elif operation == '*':
                print(f"Result: {multiply(num1, num2)}\n")
            elif operation == '/':
                print(f"Result: {divide(num1, num2)}\n")
        except ValueError:
            print("Invalid input. Please enter numeric values.\n")

if __name__ == "__main__":
    calculator()
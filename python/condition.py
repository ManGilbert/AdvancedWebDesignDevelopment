"""""
try:
    age = int(input("Enter your age: "))
    
    if age >= 18:
        print("you are adult")
    else:
        print("You are junior")
        
except (ValueError, TypeError):
    print("Invalid")
"""
try:
    yr = int(input("Enter your year of birth: "))
    current_year = 2026
    age = current_year - yr

    if age >= 18:
        print("You are allowed")
    else:
        print("You are not allowed")

except ValueError:
    print("Invalid input")
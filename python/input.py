"""
rll_nmbr = input("Enter your roll number: ")
clss = input("Entrt your class: ")
academic = input("Enter your academic: ")

print("Yello!: ", (rll_nmbr))
print("Your class is:", (clss), "and your academic is: ", (academic))


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
    
    if yr >= 2000:
        print("you allwoed ")
    else:
        print("You are not allowed")
        
except (ValueError, TypeError):
    print("Invalid")
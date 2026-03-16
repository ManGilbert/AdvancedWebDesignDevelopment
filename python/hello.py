""" 
print("Hello, World!")

a = 5
b = 3
sum = a + b

print("The sum is:", sum)



num = int(input("Enter a number: "))

if num % 2 == 0:
    print("Even number")
else:
    print("Odd number")


num1 = int(input("Enter first number: "))
num2 = int(input("Enter second number: "))

result = num1 + num2

print("Result:", result)



def fib(n):
    a, b = 0, 1
    while a < n:
        print(a, end=' ')
        a, b = b, a+b
        print()
fib(1000)

i = 1
while i < 6:
  print(i)
  if i == 4:
    break
  i += 1

  
temp1 = 77
celsius1 = (temp1 - 32) * 5 / 9
print(celsius1)

temp2 = 95
celsius2 = (temp2 - 32) * 5 / 9
print(celsius2)

temp3 = 50
celsius3 = (temp3 - 32) * 5 / 9
print(celsius3)  """

x = 300

def myfunc():
  x = 200
  print(x)

myfunc()
myfunc()

print(x)
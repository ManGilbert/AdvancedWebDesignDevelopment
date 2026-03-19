class SmartCalc:
    def __init__(self):
        self.actions = {
            "1": ("Add", self._sum),
            "2": ("Minus", self._difference),
            "3": ("Times", self._product),
            "4": ("Divide", self._quotient)
        }

    def _sum(self, a, b):
        return a + b

    def _difference(self, a, b):
        return a - b

    def _product(self, a, b):
        return a * b

    def _quotient(self, a, b):
        if b == 0:
            return "Cannot divide by zero!"
        return a / b

    def run(self):
        print("=== Smart Calculator ===")

        while True:
            print("\nChoose operation:")
            for key, (name, _) in self.actions.items():
                print(f"{key}: {name}")
            print("0: Exit")

            choice = input("Enter choice: ").strip()

            if choice == "0":
                print("Goodbye")
                break

            if choice not in self.actions:
                print("Invalid choice. Try again.")
                continue

            try:
                x = float(input("Enter first number: "))
                y = float(input("Enter second number: "))

                operation_name, func = self.actions[choice]
                result = func(x, y)

                print(f"{operation_name} Result = {result}")

            except ValueError:
                print("Please enter valid numbers.")


if __name__ == "__main__":
    calc_app = SmartCalc()
    calc_app.run()
class GradeSystem:
    def __init__(self):
        pass

    def calculate_grade(self, score):
        if score >= 90:
            return "A"
        elif score >= 80:
            return "B"
        elif score >= 70:
            return "C"
        elif score >= 60:
            return "D"
        else:
            return "F"

    def start(self):
        print("=== Grade Calculator ===")

        while True:
            user_input = input("\nEnter marks (or type 'exit'): ")

            if user_input.lower() == "exit":
                print("Goodbye")
                break

            try:
                marks = float(user_input)

                if marks < 0 or marks > 100:
                    print("Marks must be between 0 and 100.")
                    continue

                grade = self.calculate_grade(marks)
                print(f"Your Grade is: {grade}")

            except ValueError:
                print("Invalid input! Please enter a number.")


if __name__ == "__main__":
    app = GradeSystem()
    app.start()
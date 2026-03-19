class flight:
    def __init__(self, capacity):
        self.capacity = capacity
        self.passengers = []
    def add_passenger(self, passenger_name):
        if not self.open_seats():
            return False
        self.passengers.append(passenger_name)
        return True 
    def open_seats(self):
        return self.capacity - len(self.passengers)
flight1 = flight(int(input("Enter flight capacity: ")))
people = ["Jean", "Paul", "Beni", "Obed"]
for person in people:
    success = flight1.add_passenger(person)
    if success:
        print(f"Added {person} to flight successfully.")
    else:
        print(f"No available seats for {person}.")
        print(f"Remaining seats: {flight1.open_seats()}")

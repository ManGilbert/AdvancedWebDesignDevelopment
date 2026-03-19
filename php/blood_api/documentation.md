🩸 Blood Donation Locator API Documentation
🔹 Base URL
http://localhost/blood-donation-api/api

(Replace with your live URL after deployment)

🔹 1. Register Blood Donor
Endpoint
POST /donors
Description

Adds a new blood donor to the system.

Request Body (JSON)
{
  "donor_name": "John Doe",
  "blood_type": "O+",
  "city": "Kigali",
  "phone": "+250788123456",
  "last_donation_date": "2025-01-01"
}
Response
{
  "status": "success",
  "message": "Donor added"
}
🔹 2. Get All Donors
Endpoint
GET /donors
Description

Returns all registered donors.

Response
{
  "status": "success",
  "data": [
    {
      "id": 1,
      "donor_name": "John Doe",
      "blood_type": "O+",
      "city": "Kigali",
      "phone": "+250788123456"
    }
  ]
}
🔹 3. Search Donor by Blood Type
Endpoint
GET /donors?blood_type=O+
Description

Returns donors matching a specific blood type.

🔹 4. Search Donor by City
Endpoint
GET /donors?city=Kigali
Description

Returns donors in a specific location.

🔹 5. Get Emergency Donors
Endpoint
GET /emergency-donors
Description

Returns donors eligible to donate immediately
(Last donation ≥ 3 months ago)

🔹 6. Delete Donor
Endpoint
DELETE /donors?id=1
Description

Deletes a donor by ID.

Response
{
  "status": "deleted"
}
🔹 Response Format

All responses follow:

{
  "status": "success",
  "data": []
}
🔹 Technologies Used

PHP (REST API)

MySQL Database

Apache Server (XAMPP)

🔹 Testing Tool

Postman
-- Add new column
INSERT INTO contacts (name, phone_number, email, address, avatar, user_id) VALUES ('Mark Cassing', '+896634223', 'mark@gmail.com', 'Zindabazar, Sylhet', null, 3)
-- Update a contact
UPDATE contacts set name = 'Cap Cassing' WHERE id = 2
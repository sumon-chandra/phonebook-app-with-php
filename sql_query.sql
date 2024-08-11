-- Add new column
INSERT INTO contacts (name, phone_number, email, address, avatar, user_id) VALUES ('Mark Cassing', '+896634223', 'mark@gmail.com', 'Zindabazar, Sylhet', null, 3)
-- Update a contact
UPDATE contacts set name = 'Cap Cassing' WHERE id = 2

-- Get all contacts by creator
SELECT 
	c.contact_name,
    c.contact_email,
    c.contact_number,
    c.contact_image,
    c.dob,
    u.id AS creator_id,
    d.district,
    g.gender,
    bg.blood AS blood_group,
    p.profession
FROM contacts AS c 
LEFT JOIN users AS u 
ON u.id = c.user_id
LEFT JOIN districts AS d 
ON d.id = c.district_id
LEFT JOIN genders AS g 
ON g.id = c.gender_id
LEFT JOIN blood_groups AS bg
ON bg.id = c.blood_group_id
LEFT JOIN professions AS p
ON p.id = c.profession_id
WHERE c.user_id = '7'
ORDER BY c.created_at DESC;

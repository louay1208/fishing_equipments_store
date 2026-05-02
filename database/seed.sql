-- Seed Data for Pêche Marine TN

-- Admin account (password: Admin123!)
INSERT INTO utilisateur (nom, prenom, email, mot_de_passe, telephone, adresse, role)
VALUES ('Admin', 'Pêche Marine', 'admin@pechemarine.tn', '$2y$12$xNGABTeryGaK9VIKbYEG0OsIYlUOp8Kc4nf.F76dIUGv3KPf1BpJ2', '71000000', 'Gabès, Tunisie', 'admin');

-- Categories
INSERT INTO categorie (nom, description, image) VALUES
('Cannes à pêche', 'Cannes pour tous types de pêche', 'cannes.jpg'),
('Moulinets', 'Moulinets spinning et casting', 'moulinets.jpg'),
('Leurres', 'Leurres souples, durs et jigs', 'leurres.jpg'),
('Accessoires', 'Hameçons, fils, plombs et équipement', 'accessoires.jpg');

-- Products
INSERT INTO produit (nom, description, prix, quantite_stock, image, categorie_id) VALUES
('Canne Surfcasting 4.20m', 'Canne en carbone pour la pêche en mer depuis la plage.', 189.90, 15, 'canne-surf-420.png', 1),
('Canne Spinning 2.10m', 'Canne spinning légère pour la pêche aux leurres.', 129.50, 20, 'canne-spin-210.png', 1),
('Moulinet Spinning 4000', 'Moulinet taille 4000, 6 roulements, anti-corrosion.', 159.90, 25, 'moulinet-4000.png', 2),
('Moulinet Surfcasting 8000', 'Moulinet longue distance avec frein progressif 15kg.', 219.00, 12, 'moulinet-8000.png', 2),
('Kit Leurres x12', 'Assortiment de 12 leurres pour la Méditerranée.', 45.90, 40, 'kit-leurres-med.png', 3),
('Jig Métal 40g', 'Jig métal holographique imitation sardine.', 8.50, 100, 'jig-sardine-40.png', 3),
('Boîte Hameçons x100', 'Assortiment de 100 hameçons inox anti-rouille.', 19.90, 45, 'hamecons-100.png', 4),
('Tresse 8 brins 300m', 'Tresse haute performance 8 brins, résistance 15kg.', 39.90, 30, 'tresse-pe2-300.png', 4);

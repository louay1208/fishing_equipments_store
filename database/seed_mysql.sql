-- Pêche Marine TN — MySQL Seed Data
-- Run AFTER schema_mysql.sql

USE peche_marine;

-- Admin account (password: admin123)
INSERT INTO utilisateur (nom, prenom, email, mot_de_passe, telephone, adresse, role)
VALUES ('Admin', 'Pêche Marine', 'admin@pechemarine.tn', '$2y$12$xNGABTeryGaK9VIKbYEG0OsIYlUOp8Kc4nf.F76dIUGv3KPf1BpJ2', '71000000', 'Gabès, Tunisie', 'admin');

-- Categories
INSERT INTO categorie (nom, description, image) VALUES
('Cannes à pêche', 'Cannes pour tous types de pêche : surfcasting, spinning, jigging', 'cannes.jpg'),
('Moulinets', 'Moulinets spinning, casting et tambour fixe', 'moulinets.jpg'),
('Leurres', 'Leurres souples, durs, jigs et cuillères', 'leurres.jpg'),
('Fils & Tresses', 'Lignes mono, tresses et fluorocarbone', 'fils.jpg'),
('Accessoires', 'Hameçons, plombs, émerillons et montages', 'accessoires.jpg'),
('Équipement', 'Sacs, boîtes, vêtements et matériel de sécurité', 'equipement.jpg');

-- Products
INSERT INTO produit (nom, description, prix, quantite_stock, image, categorie_id) VALUES
-- Cannes
('Canne Surfcasting Méditerranée 4.20m', 'Canne robuste en carbone haute résistance, idéale pour la pêche en mer depuis la plage. Puissance 100-200g.', 189.90, 15, 'canne-surf-420.png', 1),
('Canne Spinning Légère 2.10m', 'Canne spinning ultra-légère pour la pêche aux leurres en bord de mer. Action fast, puissance 5-25g.', 129.50, 20, 'canne-spin-210.png', 1),
('Canne Jigging 1.80m', 'Canne de jigging vertical pour la pêche en bateau. Puissance 60-150g, blank carbone HM.', 245.00, 8, 'canne-jigging-180.png', 1),
('Canne Bolognaise Télescopique 5m', 'Canne bolognaise télescopique en graphite léger, idéale pour la pêche en port et digue. Puissance 10-40g.', 159.00, 12, 'canne-bolo-500.png', 1),
-- Moulinets
('Moulinet Spinning 4000 Mer', 'Moulinet taille 4000, 6 roulements, anti-corrosion marine. Ratio 5.2:1, frein 10kg.', 159.90, 25, 'moulinet-4000.png', 2),
('Moulinet Surfcasting 8000', 'Moulinet longue distance, bobine conique aluminium, frein avant progressif 15kg.', 219.00, 12, 'moulinet-8000.png', 2),
('Moulinet Jigging 5000 PE3', 'Moulinet puissant pour le jigging, engrenages renforcés, frein carbone 18kg.', 289.00, 6, 'moulinet-jigging-5000.png', 2),
('Moulinet Baitcasting Pro', 'Moulinet casting low profile avec frein magnétique, ratio 7.1:1, 8 roulements. Idéal pêche au lancer.', 175.00, 10, 'moulinet-baitcast.png', 2),
-- Leurres
('Kit Leurres Méditerranée x12', 'Assortiment de 12 leurres sélectionnés pour la Méditerranée : jigs, minnows, poppers.', 45.90, 40, 'kit-leurres-med.png', 3),
('Jig Métal 40g Sardine', 'Jig métal holographique imitation sardine, idéal bonite et sériole. 40g.', 8.50, 100, 'jig-sardine-40.png', 3),
('Popper Surface 120mm', 'Leurre de surface popper, idéal pour la pêche au bar et liche. 120mm, 35g.', 14.90, 50, 'popper-120.png', 3),
('Turluttes Calamar x5', 'Lot de 5 turluttes phosphorescentes pour la pêche au calamar. Tailles 2.5 à 3.5. Coloris assortis.', 24.90, 35, 'squid-jigs-x5.png', 3),
-- Fils & Tresses
('Tresse 8 brins PE2 300m', 'Tresse haute performance 8 brins, résistance 15kg, diamètre 0.23mm. Coloris multicolore.', 39.90, 30, 'tresse-pe2-300.png', 4),
('Fluorocarbone Leader 50m', 'Bas de ligne fluorocarbone invisible, 0.35mm, résistance 8kg. Idéal montage leurre.', 12.90, 60, 'fluoro-50m.png', 4),
('Nylon Monofilament 500m', 'Fil nylon haute résistance 0.30mm, 8kg de résistance. Bobine 500m, transparent.', 15.90, 55, 'mono-nylon-500.png', 4),
-- Accessoires
('Boîte d''hameçons mer x100', 'Assortiment de 100 hameçons inox anti-rouille, tailles 1/0 à 6/0.', 19.90, 45, 'hamecons-100.png', 5),
('Kit Plombs Surfcasting 10pcs', 'Plombs grappins et pyramides de 80g à 150g pour le surfcasting.', 22.50, 35, 'plombs-surf.png', 5),
('Émerillons Rolling x20', 'Émerillons à bille rolling inox, résistance 25kg. Pack de 20.', 7.90, 80, 'emerillons-20.png', 5),
('Pince de Pêche Multifonction', 'Pince inox avec coupe-fil, dégorgeoir et anneau brisé. Poignée antidérapante + cordon.', 29.90, 25, 'pince-peche.png', 5),
('Boîte de Rangement Tackle', 'Boîte étanche à 12 compartiments ajustables pour ranger leurres, hameçons et accessoires.', 18.50, 40, 'boite-tackle.png', 5),
-- Équipement
('Sac à Dos Pêche 40L', 'Sac à dos étanche multi-poches, porte-cannes intégré. Volume 40 litres.', 79.90, 10, 'sac-peche-40l.png', 6),
('Gilet de Sauvetage 150N', 'Gilet de sauvetage gonflable automatique, norme CE 150N. Indispensable en bateau.', 89.00, 15, 'gilet-150n.png', 6),
('Fourreau 3 Cannes 150cm', 'Housse rembourrée pour transporter jusqu''à 3 cannes montées. Bandoulière + poches latérales.', 45.00, 18, 'fourreau-3cannes.png', 6),
('Lampe Frontale LED Rechargeable', 'Lampe frontale étanche 300 lumens, modes blanc et rouge. Rechargeable USB, autonomie 8h.', 34.90, 30, 'lampe-frontale.png', 6);

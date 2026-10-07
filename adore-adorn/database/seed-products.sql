SET search_path TO adore_adorn;
-- Seed products for Adore & Adorn
-- Run AFTER schema.sql (needs the `categories` and `products` tables).
-- Images live in /uploads/products/ and are referenced by filename.
-- Safe to re-run: categories and products are only inserted if missing.

-- Extra categories (the base file only creates Jewellery / Clothing / Accessories)
INSERT INTO categories (name) SELECT 'Earrings' WHERE NOT EXISTS (SELECT 1 FROM categories WHERE name='Earrings');
INSERT INTO categories (name) SELECT 'Necklaces' WHERE NOT EXISTS (SELECT 1 FROM categories WHERE name='Necklaces');
INSERT INTO categories (name) SELECT 'Bracelets' WHERE NOT EXISTS (SELECT 1 FROM categories WHERE name='Bracelets');

INSERT INTO products (category_id, name, description, price, stock, image)
SELECT (SELECT id FROM categories WHERE name='Earrings' LIMIT 1), 'Daydream Luster Studs', 'Classic round solitaire-style studs with a sparkling crystal centre and a delicate crown setting. Light enough for all-day wear and simple enough to go from office to evening.', 599.00, 40, 'daydream-luster-studs.jpg'
WHERE NOT EXISTS (SELECT 1 FROM products WHERE name='Daydream Luster Studs');

INSERT INTO products (category_id, name, description, price, stock, image)
SELECT (SELECT id FROM categories WHERE name='Necklaces' LIMIT 1), 'Solitaire Glow Diamond Necklace', 'A dainty round pendant with a single brilliant centre stone on a fine gold-tone chain. A minimal everyday necklace that works as a first piece or a gift.', 6999.00, 12, 'solitaire-glow-diamond-necklace.jpg'
WHERE NOT EXISTS (SELECT 1 FROM products WHERE name='Solitaire Glow Diamond Necklace');

INSERT INTO products (category_id, name, description, price, stock, image)
SELECT (SELECT id FROM categories WHERE name='Bracelets' LIMIT 1), 'Blush Tulip Bracelet', 'A gold-tone vine bracelet set with crystal leaves and round stones, presented in a blush-pink gift box.', 1499.00, 20, 'blush-tulip-bracelet.jpg'
WHERE NOT EXISTS (SELECT 1 FROM products WHERE name='Blush Tulip Bracelet');

INSERT INTO products (category_id, name, description, price, stock, image)
SELECT (SELECT id FROM categories WHERE name='Earrings' LIMIT 1), 'Aurelia Vine Pearl Drops', 'Gold-tone drop earrings shaped like a trailing olive vine, finished with a teardrop pearl at the end. A graceful statement piece for festive and wedding looks.', 1299.00, 25, 'aurelia-vine-pearl-drops.jpg'
WHERE NOT EXISTS (SELECT 1 FROM products WHERE name='Aurelia Vine Pearl Drops');

INSERT INTO products (category_id, name, description, price, stock, image)
SELECT (SELECT id FROM categories WHERE name='Necklaces' LIMIT 1), 'Petals Cluster Diamond Necklace', 'Marquise-cut stones arranged in a leaf-like cluster across a fine gold-tone chain. Light, elegant and made to layer.', 8499.00, 10, 'petals-cluster-diamond-necklace.jpg'
WHERE NOT EXISTS (SELECT 1 FROM products WHERE name='Petals Cluster Diamond Necklace');

INSERT INTO products (category_id, name, description, price, stock, image)
SELECT (SELECT id FROM categories WHERE name='Bracelets' LIMIT 1), 'Black Square Stone Bracelet', 'A slim silver-tone chain bracelet with black square stones and clear accents spaced along it. Modern, edgy and easy to stack.', 1199.00, 22, 'black-square-stone-bracelet.jpg'
WHERE NOT EXISTS (SELECT 1 FROM products WHERE name='Black Square Stone Bracelet');

INSERT INTO products (category_id, name, description, price, stock, image)
SELECT (SELECT id FROM categories WHERE name='Earrings' LIMIT 1), 'Anwen Floral Crystal Earring', 'Silver-tone huggie hoops wrapped in crystal-set leaves. Snug against the ear, with a sparkle that catches the light from every angle.', 899.00, 30, 'anwen-floral-crystal-earring.jpg'
WHERE NOT EXISTS (SELECT 1 FROM products WHERE name='Anwen Floral Crystal Earring');

INSERT INTO products (category_id, name, description, price, stock, image)
SELECT (SELECT id FROM categories WHERE name='Necklaces' LIMIT 1), 'Dior Fleur Diamond Necklace', 'A station necklace of small floral motifs spaced evenly along a gold-tone chain. Our top pick for occasion wear.', 9999.00, 8, 'dior-fleur-diamond-necklace.jpg'
WHERE NOT EXISTS (SELECT 1 FROM products WHERE name='Dior Fleur Diamond Necklace');

INSERT INTO products (category_id, name, description, price, stock, image)
SELECT (SELECT id FROM categories WHERE name='Bracelets' LIMIT 1), 'Anti Tarnish Gold Bracelet', 'A sleek gold-tone bangle-style bracelet with an anti-tarnish finish, delivered in a navy gift box.', 999.00, 35, 'anti-tarnish-gold-bracelet.jpg'
WHERE NOT EXISTS (SELECT 1 FROM products WHERE name='Anti Tarnish Gold Bracelet');

INSERT INTO products (category_id, name, description, price, stock, image)
SELECT (SELECT id FROM categories WHERE name='Earrings' LIMIT 1), 'Geo Frame Stud Earrings - (Silver-Pink)', 'Square pink crystal studs framed with a halo of tiny stones. A soft pop of colour that pairs with both western and ethnic outfits.', 749.00, 35, 'geo-frame-stud-earrings-silver-pink.jpg'
WHERE NOT EXISTS (SELECT 1 FROM products WHERE name='Geo Frame Stud Earrings - (Silver-Pink)');

INSERT INTO products (category_id, name, description, price, stock, image)
SELECT (SELECT id FROM categories WHERE name='Necklaces' LIMIT 1), '925 Silver Diamond Necklace', 'A four-leaf clover pendant on a fine 925 silver chain. A symbol of luck, in a size that is subtle enough to wear every day.', 4999.00, 15, '925-silver-diamond-necklace.jpg'
WHERE NOT EXISTS (SELECT 1 FROM products WHERE name='925 Silver Diamond Necklace');

INSERT INTO products (category_id, name, description, price, stock, image)
SELECT (SELECT id FROM categories WHERE name='Bracelets' LIMIT 1), 'Minimalistic Flower Bracelet', 'A fine gold-tone chain bracelet with small pearl-centred flowers placed along it. Delicate enough for daily wear.', 799.00, 40, 'minimalistic-flower-bracelet.jpg'
WHERE NOT EXISTS (SELECT 1 FROM products WHERE name='Minimalistic Flower Bracelet');

INSERT INTO products (category_id, name, description, price, stock, image)
SELECT (SELECT id FROM categories WHERE name='Earrings' LIMIT 1), 'Candy Cube Earrings', 'Cushion-cut pink stones hanging from slim crystal-set huggies, set in a warm gold finish. Playful, pretty and easy to dress up.', 849.00, 30, 'candy-cube-earrings.jpg'
WHERE NOT EXISTS (SELECT 1 FROM products WHERE name='Candy Cube Earrings');

INSERT INTO products (category_id, name, description, price, stock, image)
SELECT (SELECT id FROM categories WHERE name='Necklaces' LIMIT 1), 'Infinity 925 Silver Diamond Necklace', 'A tiny infinity pendant with sparkling detail on a slim 925 silver chain. A thoughtful gift for birthdays and anniversaries.', 4499.00, 18, 'infinity-925-silver-diamond-necklace.jpg'
WHERE NOT EXISTS (SELECT 1 FROM products WHERE name='Infinity 925 Silver Diamond Necklace');

INSERT INTO products (category_id, name, description, price, stock, image)
SELECT (SELECT id FROM categories WHERE name='Bracelets' LIMIT 1), 'Minimalistic Silver Bracelet', 'A mixed-link silver-tone chain bracelet with a small star motif, and an adjustable clasp for a comfortable fit.', 899.00, 38, 'minimalistic-silver-bracelet.jpg'
WHERE NOT EXISTS (SELECT 1 FROM products WHERE name='Minimalistic Silver Bracelet');

INSERT INTO products (category_id, name, description, price, stock, image)
SELECT (SELECT id FROM categories WHERE name='Bracelets' LIMIT 1), '24k Gold Plated Bracelet', 'A fine beaded-chain bracelet with a 24k gold-plated finish and an adjustable extender chain.', 699.00, 45, '24k-gold-plated-bracelet.jpg'
WHERE NOT EXISTS (SELECT 1 FROM products WHERE name='24k Gold Plated Bracelet');

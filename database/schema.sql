-- ============================================================
--  Wildlife Podcast Admin — Database Schema
--  Database : MySQL 8+
-- ============================================================

CREATE DATABASE IF NOT EXISTS wildlife_podcast;
USE wildlife_podcast;

-- ── podcasts table ──────────────────────────────────────────
CREATE TABLE podcasts (
  id          INT           AUTO_INCREMENT PRIMARY KEY,
  title       VARCHAR(100)  NOT NULL,
  description VARCHAR(500)  NOT NULL,
  thumbnail   VARCHAR(500)  NOT NULL,
  file_url    VARCHAR(500)  NOT NULL,
  date_added  DATE          NOT NULL DEFAULT (CURDATE()),
  created_at  TIMESTAMP     DEFAULT CURRENT_TIMESTAMP,
  updated_at  TIMESTAMP     DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- ── Sample Records ──────────────────────────────────────────
INSERT INTO podcasts (title, description, thumbnail, file_url, date_added) VALUES
(
  'The Wildlife Trusts - Wild About Wellbeing',
  'Wild About Wellbeing is a podcast by The Wildlife Trusts. Here, we talk about all things to do with nature and health.',
  'https://images.unsplash.com/photo-1564349683136-77e08dba1ef7?w=400&h=240&fit=crop',
  'https://example.com/podcast1.mp3',
  '2024-09-12'
),
(
  'Surrey Wildlife Trust',
  'From wildlife gardening to river restoration, episodes cover a range of nature themed topics and feature a wildlife experts',
  'https://images.unsplash.com/photo-1502082553048-f009c37129b9?w=400&h=240&fit=crop',
  'https://example.com/podcast2.mp3',
  '2024-09-06'
),
(
  'Lancashire Wildlife Trust',
  'Find out about new nature projects, how to care for wildlife and insights into a career in conservation.',
  'https://images.unsplash.com/photo-1444927714506-8492d94b5ba0?w=400&h=240&fit=crop',
  'https://example.com/podcast3.mp3',
  '2024-09-02'
),
(
  'Cornwall Wildlife Trust',
  'Embark on an audio adventure as you travel from the rugged cliffs of Cornwall coastline to deep wooded valleys and everywhere in between.',
  'https://images.unsplash.com/photo-1507525428034-b723cf961d3e?w=400&h=240&fit=crop',
  'https://example.com/podcast4.mp3',
  '2024-08-28'
),
(
  'Buckinghamshire and Oxfordshire Wildlife Trust',
  'From ponds to swifts and letting your grass grow long, join us as we explore what wildlife gardening means.',
  'https://images.unsplash.com/photo-1416879595882-3373a0480b5b?w=400&h=240&fit=crop',
  'https://example.com/podcast5.mp3',
  '2024-08-20'
),
(
  'Derbyshire Wildlife Trust',
  'Explore Derbyshire wildlife and wild places from the River Erewash to the birds of the Dark Peak.',
  'https://images.unsplash.com/photo-1474511320723-9a56873867b5?w=400&h=240&fit=crop',
  'https://example.com/podcast6.mp3',
  '2024-08-12'
),
(
  'Essex Wildlife Trust',
  'Welcome to The Wildlife Explorer, where we aim to inspire you with our work to protect the wildlife and wild spaces in Essex.',
  'https://images.unsplash.com/photo-1551085254-e96b210db58a?w=400&h=240&fit=crop',
  'https://example.com/podcast7.mp3',
  '2024-08-05'
),
(
  'Nottinghamshire Wildlife Trust',
  'This podcast features conversations with communities, volunteers and people who work in wonderful Sherwood Forest.',
  'https://images.unsplash.com/photo-1448375240586-882707db888b?w=400&h=240&fit=crop',
  'https://example.com/podcast8.mp3',
  '2024-07-26'
),
(
  'Dorset Wildlife Trust',
  'Hear from our expert staff, trustees, volunteers and special guests about Dorset Wildlife Trust work to protect wildlife and wild places.',
  'https://images.unsplash.com/photo-1522587040-6c5e5f4a7568?w=400&h=240&fit=crop',
  'https://example.com/podcast9.mp3',
  '2024-07-17'
);

# Wildlife Admin Panel — Task 2

A React-based Admin Page for managing Wildlife Podcasts with full CRUD functionality.

---

## Project Structure

```
wildlife-admin/
├── public/
│   └── index.html
├── src/
│   ├── components/
│   │   ├── Navbar.jsx           → Top navigation bar
│   │   ├── AddPodcastForm.jsx   → Form to add a new podcast
│   │   ├── StatsCard.jsx        → Total podcast count display
│   │   ├── PodcastList.jsx      → Grid list of all podcasts
│   │   ├── PodcastCard.jsx      → Individual podcast card (Edit/Delete/Play)
│   │   ├── EditModal.jsx        → Popup modal to edit a podcast
│   │   ├── DeleteConfirm.jsx    → Confirmation dialog for delete
│   │   ├── Toast.jsx            → Success notification popup
│   │   └── validation.js        → Regex-based form validation rules
│   ├── data/
│   │   └── podcasts.json        → Initial podcast data (JSON)
│   ├── styles/
│   │   ├── index.css            → Global / shared styles
│   │   ├── App.css              → Layout styles
│   │   ├── Navbar.css
│   │   ├── AddPodcastForm.css
│   │   ├── StatsCard.css
│   │   ├── PodcastCard.css
│   │   ├── PodcastList.css
│   │   ├── EditModal.css
│   │   ├── DeleteConfirm.css
│   │   └── Toast.css
│   ├── App.jsx                  → Root component (state management)
│   └── index.js                 → React entry point
├── database/
│   └── schema.sql               → MySQL database schema + sample data
├── package.json
└── README.md
```

---

## How to Run

### Step 1 — Install Node.js
Download from https://nodejs.org (LTS version recommended)

### Step 2 — Install dependencies
```bash
cd wildlife-admin
npm install
```

### Step 3 — Start the app
```bash
npm start
```

Open http://localhost:3000 in your browser.

---

## CRUD Features

| Feature        | Description                                              |
|----------------|----------------------------------------------------------|
| Add Podcast    | Fill form → click "Add Podcast" → appears in grid        |
| View Podcasts  | 3-column responsive grid with image, date, title, desc   |
| Edit Podcast   | Click "Edit" on card → modal opens → update → save       |
| Delete Podcast | Click "Delete" → confirmation dialog → removed from list |

---

## Form Validation (Regex)

All fields are validated using regular expressions before submission.

| Field            | Regex Rule                                      | Rule Description               |
|------------------|-------------------------------------------------|-------------------------------|
| Podcast Name     | `/^.{3,100}$/`                                  | 3 to 100 characters           |
| Description      | `/^.{10,500}$/`                                 | 10 to 500 characters          |
| Podcast Thumbnail| `/^(https?:\/\/.+\|.+\.(jpg\|jpeg\|png\|webp))$/i` | Valid image URL or file    |
| Podcast File     | `/^(https?:\/\/.+\|.+\.(mp3\|wav\|ogg\|aac))$/i`  | Valid audio URL or file    |

---

## Database Setup (MySQL)

```bash
mysql -u root -p < database/schema.sql
```

Or open MySQL Workbench and run the file `database/schema.sql`.

---

## Dependencies

| Package         | Version  | Purpose                  |
|-----------------|----------|--------------------------|
| react           | ^18.2.0  | UI framework             |
| react-dom       | ^18.2.0  | DOM rendering            |
| react-scripts   | 5.0.1    | Build tooling (CRA)      |
| Google Fonts    | CDN      | Poppins font family      |

---

## Additional Features

1. **Regex Form Validation** — All 4 fields validated with error messages shown inline
2. **Edit Modal** — Animated popup with pre-filled data for easy editing
3. **Delete Confirmation** — Dialog prevents accidental deletion
4. **Toast Notifications** — Success message after every add / edit / delete
5. **Live Total Count** — Stats card updates instantly when podcasts are added/deleted
6. **Browse Button** — Native file picker for thumbnail and audio file upload
7. **Fully Responsive** — Desktop (3-col) → Tablet (2-col) → Mobile (1-col)
8. **Image Fallback** — Broken thumbnail replaced with default wildlife image
9. **View All / Show Less** — Expands list when more than 9 podcasts exist
10. **Sticky Navbar** — Navigation stays fixed at top while scrolling

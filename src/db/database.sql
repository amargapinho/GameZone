BEGIN TRANSACTION;
CREATE TABLE IF NOT EXISTS "categories" (
	"categorieID"	INTEGER NOT NULL,
	"categoryName"	TEXT NOT NULL UNIQUE,
	"deleted"	INTEGER NOT NULL,
	PRIMARY KEY("categorieID" AUTOINCREMENT)
);
CREATE TABLE IF NOT EXISTS "games" (
	"gameID"	INTEGER NOT NULL,
	"gameName"	TEXT NOT NULL,
	"description"	TEXT NOT NULL,
	"releaseDate"	INTEGER NOT NULL,
	"wishlisted"	INTEGER NOT NULL,
	"deleted"	INTEGER NOT NULL,
	PRIMARY KEY("gameID" AUTOINCREMENT)
);
CREATE TABLE IF NOT EXISTS "gameCategories" (
	"gameID"	INTEGER NOT NULL,
	"categorieID"	INTEGER NOT NULL,
	FOREIGN KEY("categorieID") REFERENCES "categories"("categorieID"),
	FOREIGN KEY("gameID") REFERENCES "games"("gameID"),
	PRIMARY KEY("gameID","categorieID")
);
CREATE TABLE IF NOT EXISTS "images" (
	"imageID"	INTEGER NOT NULL,
	"imageName"	TEXT NOT NULL UNIQUE,
	"gameID"	INTEGER NOT NULL,
	"deleted"	INTEGER NOT NULL,
	FOREIGN KEY("gameID") REFERENCES "games"("gameID"),
	PRIMARY KEY("imageID" AUTOINCREMENT)
);
CREATE INDEX IF NOT EXISTS "wishlisted" ON "games" (
	"wishlisted"
);
CREATE INDEX IF NOT EXISTS "deletedGames" ON "games" (
	"deleted"
);
CREATE INDEX IF NOT EXISTS "deletedCategories" ON "categories" (
	"deleted"
);
COMMIT;

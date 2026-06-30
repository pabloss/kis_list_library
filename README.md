# KIS List - Zadanie Rekrutacyjne

Proste API dla systemu informatycznego biblioteki. 

## Technologie

- PHP 8.4
- Symfony 7
- PostgreSQL 16
- Docker & Docker Compose

## Uruchomienie projektu

1. Sklonuj repozytorium.
2. Uruchom polecenie:
   ```bash
   docker compose up
   ```
   *To polecenie pobierze obrazy, zbuduje kontener aplikacji, zainstaluje pakiety Composera, uruchomi migracje bazy danych oraz wystartuje wbudowany serwer PHP na porcie 8000.*

3. API będzie dostępne pod adresem: `http://localhost:8000/api/books`

## Endopinty API

### 1. Pobranie listy wszystkich książek
- **URL**: `GET /api/books`
- **Odpowiedź**: `200 OK` (JSON)

### 2. Dodanie nowej książki
- **URL**: `POST /api/books`
- **Body** (JSON):
  ```json
  {
      "serialNumber": "123456",
      "title": "Wiedźmin",
      "author": "Andrzej Sapkowski"
  }
  ```
- **Odpowiedź**: `201 Created`

### 3. Usunięcie książki
- **URL**: `DELETE /api/books/{id}`
- **Odpowiedź**: `204 No Content`

### 4. Aktualizacja stanu książki (wypożyczona / dostępna)
- **URL**: `PATCH /api/books/{id}/status`
- **Body** (JSON):
  - Aby wypożyczyć:
    ```json
    {
        "isBorrowed": true,
        "borrowedBy": "987654"
    }
    ```
  - Aby zwrócić:
    ```json
    {
        "isBorrowed": false
    }
    ```
- **Odpowiedź**: `200 OK` (zaktualizowany obiekt książki)

## Założenia architektoniczne
- Stosuję Controllery, które są wywoływane poprzez `__invoke`;
- Stosuję walidację, serializacjęi i mapowanie ORM przez pliki XML-stosuję tym samym regułę SRP. To ułatwia testowanie i utrzymanie kodu w przyszłości.
- SRP można wzmocnić poprzez wprowadzenie warstwy serwisów, które będą odpowiedzialne za logikę biznesową. W tym przypadku nie jest to konieczne, ponieważ logika jest prosta i nie wymaga dodatkowej warstwy. Intensywnie można by stosować `#[MapRequestPayload]`.

## Założenia dodatkowe
- Ponieważ jest to podane w założeniach zadania, a aplikacja jest niewielka, nie tworzę encji użytkownika. Wypożyczenie książki odbywa się poprzez przekazanie numeru karty bibliotecznej w żądaniu PATCH.
- Numer książki to unikalny 6-cyfrowy ciąg znaków.
- Numer karty bibliotecznej to 6-cyfrowy ciąg znaków (przekazywany przy wypożyczaniu).

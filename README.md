# Planificació i preguntes clau

Abans de picar una sola línia de codi productiu, cal tenir clar:

### 1. Quina informació vull registrar?
- Llibres: títol, descripció, data de publicació, foto, contingut, estat, autor.
- Usuaris: nom, email, rol, etc.
- Gèneres, escriptors, likes, rols.

### 2. Què pot fer cada tipus d’usuari?
- **Administrador**: pot gestionar usuaris, llibres, gèneres, escriptors i assignar rols.
- **Editor**: pot crear, editar i eliminar llibres.
- **Usuari registrat**: pot veure llibres, donar likes, comentar.
- **Visitant**: només pot veure llibres públics.

### 3. Quins són els endpoints que faré servir perquè els usuaris hi accedeixin?
- `/api/books`: CRUD de llibres.
- `/api/genres`: CRUD de gèneres.
- `/api/writers`: CRUD d’escriptors.
- `/api/likes`: donar o treure likes.
- `/api/users`: gestió d’usuaris (només admins).
- `/api/auth`: registre, login, logout.

---

## Seguretat

- **Autenticació amb Passport**: Totes les rutes de l’API requereixen autenticació OAuth2 amb Laravel Passport.
- **Sistema de rols**: Defineix rols (admin, editor, usuari) i restringeix l’accés a les rutes segons el nivell de privilegis.
- **Middleware**: Utilitza middleware per verificar el rol abans de permetre accedir a cada endpoint.

---

## Testing

- **TDD**: Escriu els tests funcionals abans d’implementar el codi de cada ruta.
- **Tests funcionals**: Cobreix tots els casos d’ús (autenticació, permisos, CRUD, likes).
- **Directori de tests**: Utilitza `tests/Feature` per als tests d’API.

---

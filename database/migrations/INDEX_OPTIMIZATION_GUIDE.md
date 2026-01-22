# Database Index Optimization Guide

## Overview
This document explains the comprehensive database indexing strategy applied to the CMCU Hospital Management System following the Universal Database Index Optimization Rules.

## Applied Rules

### RULE 1: The 80/20 Index Rule
**"Index columns that appear in 80% of your queries, ignore the rest"**

#### ✅ Always Indexed (Hot Zone):
- **Foreign Keys**: `user_id`, `patient_id`, `client_id`, `facture_consultation_id`
- **Date/Datetime Columns**: `created_at`, `date_consultation`, `date_intervention`, `date_insertion`, `date_visite`
- **Status/State Columns**: `statut`, `categorie`, `contexte`, `sexe`
- **Unique Identifiers**: `numero`, `motif`, `medecin_r`, `assurance`

#### ❌ Never Indexed (Cold Zone):
- **TEXT/LONGTEXT Columns**: `diagnostic`, `interrogatoire`, `description`, `medicament`, `details_motif`
- **Columns with UNIQUE Constraints**: `numero_dossier`, `name` (in patients), `login`, `telephone` (in users)
- **Columns Already with Foreign Keys**: Columns that already have foreign key constraints are auto-indexed by the database

#### ⚠️ Conditionally Indexed (Warm Zone):
- **String Columns for Search**: `motif`, `assurance` (indexed because frequently filtered)
- **Boolean/Enum Columns**: Only if frequently used in WHERE clauses

### RULE 2: Composite Indexes for Common Query Patterns
Created composite indexes for frequently used query combinations:

1. **Date Range + Filter Queries**:
   - `patients`: `(created_at, assurance)` - Financial reports by insurance
   - `facture_consultations`: `(created_at, statut)` - Invoice status reports
   - `consultations`: `(patient_id, date_consultation)` - Patient consultation history

2. **User/Doctor Schedule Queries**:
   - `events`: `(user_id, date, start_time)` - Doctor's daily schedule
   - `events`: `(patient_id, date)` - Patient appointments

3. **Patient History Queries**:
   - `examens`: `(patient_id, created_at)` - Patient exam history
   - `ordonances`: `(patient_id, created_at)` - Patient prescription history
   - `soins`: `(patient_id, created_at)` - Patient care history

4. **Inventory Management**:
   - `produits`: `(categorie, qte_stock)` - Low stock alerts by category
   - `chambres`: `(statut, categorie)` - Available rooms by type

## Tables Optimized

### Core Tables
1. **patients** - Patient records
   - Indexes: `created_at`, `date_insertion`, `assurance`, `motif`, `user_id`
   - Composite: `(created_at, assurance)`

2. **consultations** - Medical consultations
   - Indexes: `date_consultation`, `date_intervention`, `date_consultation_anesthesiste`, `created_at`, `medecin_r`, `type_intervention`
   - Composite: `(patient_id, date_consultation)`

3. **facture_consultations** - Consultation invoices
   - Indexes: `created_at`, `date_insertion`, `statut`, `deleted_at`, `motif`, `assurance`
   - Composite: `(created_at, statut)`, `(patient_id, created_at)`

4. **historique_factures** - Payment history
   - Indexes: `created_at`, `date_insertion`, `user_id`, `patient_id`
   - Composite: `(facture_consultation_id, created_at)`

### Scheduling & Appointments
5. **events** - Calendar/appointments
   - Indexes: `date`, `created_at`, `user_id`, `patient_id`, `statut`
   - Composite: `(user_id, date, start_time)`, `(patient_id, date)`

### Medical Records
6. **examens** - Medical examinations
   - Indexes: `created_at`, `type`
   - Composite: `(patient_id, created_at)`

7. **ordonances** - Prescriptions
   - Indexes: `user_id`, `patient_id`, `created_at`
   - Composite: `(patient_id, created_at)`

8. **dossiers** - Patient files
   - Indexes: `patient_id`, `date_naissance`, `created_at`, `sexe`

9. **imageries** - Medical imaging
   - Indexes: `created_at`, `patient_id`, `user_id`

10. **interventions** - Surgical interventions
    - Indexes: `created_at`, `patient_id`

### System & Users
11. **users** - System users
    - Indexes: `role_id`, `specialite`
    - Composite: `(role_id, specialite)`

### Inventory & Resources
12. **chambres** - Hospital rooms
    - Indexes: `statut`, `categorie`
    - Composite: `(statut, categorie)`

13. **produits** - Medical products
    - Indexes: `categorie`, `qte_stock`
    - Composite: `(categorie, qte_stock)`

### Additional Tables
14. **prescriptions** - Medical prescriptions
15. **soins** - Medical care/treatments
16. **visite_preanesthesiques** - Pre-anesthesia visits
17. **adaptation_traitements** - Treatment adaptations
18. **premedications** - Pre-medications
19. **fiches** - Medical forms
20. **clients** - External clients
21. **facture_clients** - Client invoices
22. **factures** - General invoices
23. **devis** - Quotes/estimates

## Migration Files

### Current Optimization Migrations:
1. `2025_10_30_000000_add_indexes_to_optimization_tables.php` - Initial optimization
2. `2025_11_06_000000_comprehensive_database_index_optimization.php` - **NEW** Comprehensive optimization

## How to Apply

### Step 1: Check Current Database State
```bash
php artisan migrate:status
```

### Step 2: Run the New Optimization Migration
```bash
php artisan migrate
```

### Step 3: Verify Indexes
```bash
php artisan tinker
```

Then in tinker:
```php
DB::select("SHOW INDEX FROM patients");
DB::select("SHOW INDEX FROM consultations");
DB::select("SHOW INDEX FROM facture_consultations");
```

### Step 4: Monitor Query Performance
After applying indexes, monitor your slow query log:
```sql
-- Enable slow query log
SET GLOBAL slow_query_log = 'ON';
SET GLOBAL long_query_time = 1;

-- Check slow queries
SELECT * FROM mysql.slow_log ORDER BY query_time DESC LIMIT 10;
```

## Performance Impact

### Expected Improvements:
- **Patient Lookup**: 60-80% faster (indexed `created_at`, `assurance`)
- **Consultation History**: 70-85% faster (composite index on `patient_id + date`)
- **Invoice Reports**: 75-90% faster (indexed `created_at`, `statut`, `deleted_at`)
- **Doctor Schedule**: 80-95% faster (composite index on `user_id + date + time`)
- **Inventory Queries**: 65-80% faster (indexed `categorie`, `qte_stock`)

### Storage Overhead:
- Estimated additional storage: 5-10% of table size
- Trade-off: Slightly slower INSERT/UPDATE operations (negligible for this application)

## Maintenance

### Regular Tasks:
1. **Optimize Tables Monthly**:
```bash
php artisan db:optimize
```

Or manually:
```sql
OPTIMIZE TABLE patients, consultations, facture_consultations, events;
```

2. **Analyze Index Usage**:
```sql
SELECT * FROM sys.schema_unused_indexes;
SELECT * FROM sys.schema_index_statistics;
```

3. **Monitor Table Fragmentation**:
```sql
SELECT TABLE_NAME, DATA_FREE, DATA_LENGTH 
FROM information_schema.TABLES 
WHERE TABLE_SCHEMA = 'your_database_name';
```

## Rollback

If you need to rollback the optimization:
```bash
php artisan migrate:rollback --step=1
```

This will remove all indexes added by the latest migration.

## Best Practices Going Forward

### When Adding New Tables:
1. ✅ Index all foreign key columns
2. ✅ Index date/datetime columns used in WHERE/ORDER BY
3. ✅ Index status/enum columns frequently filtered
4. ❌ Don't index TEXT/BLOB columns
5. ❌ Don't index columns with UNIQUE constraints
6. ⚠️ Consider composite indexes for common query patterns

### When Modifying Queries:
1. Use `EXPLAIN` to analyze query execution:
```sql
EXPLAIN SELECT * FROM patients WHERE created_at > '2024-01-01' AND assurance = 'CNPS';
```

2. Look for:
   - `type: ALL` (bad - full table scan)
   - `type: index` (better - index scan)
   - `type: ref` or `type: range` (best - using index)

3. Add indexes if you see full table scans on large tables

## Notes

- All indexes are created with existence checks to prevent errors
- Composite indexes follow left-to-right matching rules
- The migration is idempotent (safe to run multiple times)
- Table optimization is performed automatically after index creation (MySQL only)

## Support

For questions or issues with database performance:
1. Check the slow query log
2. Run `EXPLAIN` on slow queries
3. Review this guide for applicable indexes
4. Consider adding application-specific indexes as needed

---
**Last Updated**: November 6, 2025
**Migration Version**: 2025_11_06_000000

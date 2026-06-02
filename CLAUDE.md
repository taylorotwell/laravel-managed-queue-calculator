# Project Notes

This is a small Laravel app that serves a single-page Laravel Cloud Managed Queues pricing calculator.

## How It Works

- The `/` route is defined in `routes/web.php` and returns the `welcome` view.
- The full UI, styling, and calculator logic live in `resources/views/welcome.blade.php`.
- There is no backend pricing logic, database model, API endpoint, or build-time JavaScript for the calculator.
- The page uses inline CSS and vanilla browser JavaScript.

## Calculator Inputs

The calculator has three range controls:

- Job volume per month, from 1,000 to 100,000,000 jobs.
- Average job duration, from 1 to 300 seconds.
- Autoscaled worker count, from 1 to 25 workers.

## Pricing Assumptions

- Worker compute rate: `$0.00000152` per worker-second.
- Queue operation rate: `$1` per million operations.
- Polling interval: `10` seconds.
- Scale-down window: `60` seconds after the queue clears.
- Month length: `30` days.
- Worker size shown in the UI: `256MB instance`.

## Formula Summary

The JavaScript calculates requested runtime as `job volume * average job duration`, caps it by monthly worker capacity, then estimates completed jobs. Compute cost is based on billed worker seconds plus the scale-down window when all jobs clear. Queue operations include submitted jobs, receive/delete operations for completed jobs, and polling operations.

If the selected workers cannot finish all jobs in the 30-day month, compute is capped by worker capacity and unprocessed jobs are not counted as received or deleted.

## Development

- Run the app with `php artisan serve`.
- Use `composer run dev` if you want the standard Laravel dev process, though this calculator does not currently depend on Vite assets.
- Run tests with `composer test`.

When editing the calculator, keep changes focused in `resources/views/welcome.blade.php` unless adding real backend behavior.

export interface TimeEntry {
  id?: number,
  title: string,
  project?: string,
  start_time: string,
  end_time: string | null,
  total_seconds: number;
}

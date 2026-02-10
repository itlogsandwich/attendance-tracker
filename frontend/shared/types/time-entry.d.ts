import type { Project } from "./project";

export interface TimeEntry {
  id?: number,
  title: string,
  project_id: number | null,
  project?: Project,
  start_time: string,
  end_time: string | null,
  total_seconds: number;
}
